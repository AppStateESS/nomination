<?php
namespace nomination\command;

use \nomination\Command;
use \nomination\Context;
use \nomination\Nomination;
use \nomination\NominationFactory;
use \nomination\view\NominationForm;
use \nomination\NominationDocument;
use \nomination\DocumentFactory;
use \nomination\Reference;
use \nomination\ReferenceFactory;
use \nomination\Period;
use \nomination\NominationFieldVisibility;
use \nomination\ReferenceEmail;
use \nomination\NominatorEmail;
use \nomination\view\NotificationView;
use \nomination\NominationSettings;
use \nomination\email\NewNominatorEmail;
use \nomination\email\NewReferenceEmail;

\PHPWS_Core::initCoreClass('Captcha.php');

/**
 * CreateNominationForm
 *
 * Check that all required fields in form are completed, if not
 * redirect back to form with neglected fields highlighted and
 * Notification at top of form.
 * If form checks out then create nominator, references,
 * nominee, and nomination.
 *
 * @author Robert Bost <bostrt at tux dot appstate dot edu>
 * @author Jeremy Booker
 * @package nomination
 */
class CreateNomination extends Command
{
    public function getRequestVars()
    {
        return array('action' => 'CreateNomination', 'after' => 'ThankYouNominator');
    }


    public static $requiredFields = array(
                    'nominee_banner_id',
                    'nominee_first_name',
				    'nominee_last_name',
				    'nominee_email',
                    'nominee_phone',
                    'nominee_gpa',
                    'nominee_asubox',
                    'nominee_class',
				    'nominator_first_name',
				    'nominator_last_name',
				    'nominator_email',
				    'nominator_phone',
				    'nominator_address',
            'reference_first_name',
            'reference_last_name',
            'reference_phone',
            'reference_email');

    public function execute(Context $context)
    {
        $missing = array();
        $entered = array();
        $emailSettings = NominationSettings::getInstance();
        $numReferencesReq = Reference::getNumReferencesReq();

        // Figure out which fields are required
        $vis = new NominationFieldVisibility();
        $required = array();
        foreach(self::$requiredFields as $field) {
            if($vis->isVisible($field))
            {
              switch($field){
                case "reference_first_name":
                case "reference_last_name":
                case "reference_phone":
                case "reference_email":
                  for($i = 0; $i < $numReferencesReq; $i++)
                  {
                    array_push($required, $field.'_'.$i);
                  }
                  break;
                default:
                  $required[] = $field;
              }
            }
        }

        /*****************
         * Check  fields *
        *****************/

        if (isset($_SESSION['redirect']) && $_SESSION['redirect'] == 'true')
        {
            \NQ::simple('nomination', NotificationView::NOMINATION_ERROR, 'Be sure to fill in all required fields.');
            \NQ::simple('nomination', NotificationView::NOMINATION_WARNING, 'Re-select your statement file before submitting.');
            unset($_SESSION['redirect']);
            //$_FILES['statement'] = $_SESSION['statement'];
            //unset($_SESSION['statement']);
        }


        // Check for missing required fields
        foreach($required as $key=>$value){
            if(!isset($context[$value]) || $context[$value] == ""){
                $missing[] = $value;
                $context['after'] = 'NominationForm';
                $fields = array('nominee_banner_id'=>$context['nominee_banner_id'],
                        'nominee_first_name'=>$context['nominee_first_name'],
                        'nominee_middle_name'=>$context['nominee_middle_name'],
                        'nominee_last_name'=>$context['nominee_last_name'],
                        'nominee_asubox'=>$context['nominee_asubox'],
                        'nominee_email'=>$context['nominee_email'],
                        'nominee_position'=>$context['nominee_position'],
                        'nominee_department_major'=>$context['nominee_department_major'],
                        'nominee_years'=>$context['nominee_years'],
                        'nominee_phone'=>$context['nominee_phone'],
                        'nominee_gpa'=>$context['nominee_gpa'],
                        'nominee_class'=>$context['nominee_class'],
                        'nominee_responsibility'=>$context['nominee_responsibility'],
                        'nominator_first_name'=>$context['nominator_first_name'],
                        'nominator_middle_name'=>$context['nominator_middle_name'],
                        'nominator_last_name'=>$context['nominator_last_name'],
                        'nominator_address'=>$context['nominator_address'],
                        'nominator_phone'=>$context['nominator_phone'],
                        'nominator_email'=>$context['nominator_email'],
                        'nominator_relationship'=>$context['nominator_relationship'],
                        'category'=>$context['category'],
                        'reference_id'=>array('0'=>$context['reference_id_0'],
                                '1'=>$context['reference_id_1'],
                                '2'=>$context['reference_id_2']),
                        'reference_first_name'=>array('0'=>$context['reference_first_name_0'],
                                '1'=>$context['reference_first_name_1'],
                                '2'=>$context['reference_first_name_2']),
                        'reference_last_name'=>array('0'=>$context['reference_last_name_0'],
                                '1'=>$context['reference_last_name_1'],
                                '2'=>$context['reference_last_name_2']),
                        'reference_department'=>array('0'=>$context['reference_department_0'],
                                '1'=>$context['reference_department_1'],
                                '2'=>$context['reference_department_2']),
                        'reference_relationship'=>array('0'=>$context['reference_relationship_0'],
                                '1'=>$context['reference_relationship_1'],
                                '2'=>$context['reference_relationship_2']),
                        'reference_phone'=>array('0'=>$context['reference_phone_0'],
                                '1'=>$context['reference_phone_1'],
                                '2'=>$context['reference_phone_2']),
                        'reference_email'=>array('0'=>$context['reference_email_0'],
                                '1'=>$context['reference_email_1'],
                                '2'=>$context['reference_email_2']),
                        'redirect'=>'true');
                $_SESSION['nomination_fields'] = $fields;
                $_SESSION['redirect'] = 'true';
                /*$_SESSION['statement'] = array('name'=>$_FILES['statement']['name'],
                                'type'=>$_FILES['statement']['type'],
                                'tmp_name'=>$_FILES['statement']['tmp_name'],
                                'error'=>$_FILES['statement']['error'],
                                'size'=>$_FILES['statement']['size']);*/
                /*var_dump($_SESSION);
                var_dump($_FILES);
                exit;*/
                return;
            } else {
                $entered[$key] = $context[$value];
            }
        }


        // Check for a "statement" file upload, if required
        if($vis->isVisible('statement')) {
            if($_FILES['statement']['error'] !== 0){
                $context['after'] = 'NominationForm';// Set after view to the form
                $context['form_fail'] = True;// Set form fail

                $msg = 'Missing statement';

                if(!empty($missing)){
                    // There are other fields missing
                    $msg .= ' and some other fields';
                }
                $missing[] = 'statement';
                $context['missing'] = $missing;// Add missing fields to context
                //throw new \nomination\exception\BadFormException($msg);
            }
        }

        // Verify the captcha
        //var_dump($_REQUEST['captcha']);
        /*
        if(!\Captcha::verify()){
            $missing[] = 'captcha';

            $context['after'] = 'NominationForm';// Set after view to the form
            $context['missing'] = $missing;// Add missing fields to context
            $context['form_fail'] = True;// Set form fail

            //throw new \nomination\exception\BadFormException('The Captcha words were incorrect.');
        }*/

        // If anything was missing, redirect back to the form
        if(!empty($missing)){

            $context['after'] = 'NominationForm';// Set after view to the form
            $context['missing'] = $missing;// Add missing fields to context
            $context['form_fail'] = True;// Set form fail

            // Throw exception
            $missingFields = implode(', ', $missing);

            //exit;
            //throw new \nomination\exception\BadFormException('The following fields are missing: ' . $missingFields);
        }

        //check for bad email
        //TODO: check nominator and nominee emails, should not contain '@'


        // TODO: Check nominee email.. Should only be username, with '@appstate.edu' *excluded*
        // TODO: Check nominator email (if provided).. Should only be username, with '@appstate.edu' *excluded*

        /***********
         * Nominee *
         ***********/
        $nomineeBannerId    = $context['nominee_banner_id'];
        $nomineeFirstName   = $context['nominee_first_name'];
        $nomineeMiddleName  = $context['nominee_middle_name'];
        $nomineeLastName    = $context['nominee_last_name'];
        $nomineeAsubox      = $context['nominee_asubox'];
        $nomineeEmail       = $context['nominee_email'];
        $nomineePosition    = $context['nominee_position'];
        $nomineeDeptMajor   = $context['nominee_department_major'];
        $nomineeYears       = $context['nominee_years'];
        $nomineePhone       = $context['nominee_phone'];
        $nomineeGpa         = $context['nominee_gpa'];
        $nomineeClass       = $context['nominee_class'];
        $nomineeResponsibility = $context['nominee_responsibility']; // jeremy sorry you can fix it bro


        /*************
         * Nominator *
         *************/
        $nominatorFirstName    = $context['nominator_first_name'];
        $nominatorMiddleName   = $context['nominator_middle_name'];
        $nominatorLastName     = $context['nominator_last_name'];
        $nominatorAddress      = $context['nominator_address'];
        $nominatorPhone        = $context['nominator_phone'];
        $nominatorEmail        = $context['nominator_email'];
        $nominatorRelation     = $context['nominator_relationship'];
        $nominatorUniqueId     = Nomination::generateUniqueId($nomineeBannerId);


        /**************
         * Nomination *
        **************/
        $category = $context['category'];
        $period = Period::getCurrentPeriod();
	      //we need this cause we're adding the period's "number" not the period object itself
	      $period_id = $period->getId();
        $nomination = new Nomination($nomineeBannerId, $nomineeFirstName, $nomineeMiddleName, $nomineeLastName,
                        $nomineeEmail, $nomineeAsubox, $nomineePosition, $nomineeDeptMajor, $nomineeYears,
                        $nomineePhone, $nomineeGpa, $nomineeClass, $nomineeResponsibility,
                        $nominatorFirstName, $nominatorMiddleName, $nominatorLastName, $nominatorAddress,
                        $nominatorPhone, $nominatorEmail, $nominatorRelation, $nominatorUniqueId, $category, $period_id);
        // Save the nomination to the db; If this works,
        // the factory will populate the $nomination with its database id.
        NominationFactory::save($nomination);


        /**************
         * References *
         **************/

        $missingFields = array();
        $references = array(); // Array holding list of Reference objects as we create/save them

        for($i = 0; $i < $numReferencesReq; $i++){
            $first_name     = $context['reference_first_name_'.$i];
            $last_name      = $context['reference_last_name_'.$i];
            $department     = $context['reference_department_'.$i];
            $phone          = $context['reference_phone_'.$i];
            $email          = $context['reference_email_'.$i];
            $relationship   = $context['reference_relationship_'.$i];

            // Check for missing refernce info. If anything other than "relationship" is missing, then we return to the form
            if(!isset($context['reference_first_name_'. $i]) && $vis->isVisible('reference_first_name_' . $i))
            {
                $missingFields[] = "reference_first_name_" . $i;
            }

            if(!isset($context['reference_last_name_' . $i]) && $vis->isVisible('reference_last_name_' . $i))
            {
                $missingFields[] = "reference_last_name_".$i;
            }

            if(!isset($context['reference_department_'. $i]) && $vis->isVisible('reference_department_'. $i))
            {
                $missingFields[] = "reference_department_".$i;
            }

            if(!isset($context['reference_phone_'.$i]) && $vis->isVisible('reference_phone_'.$i))
            {
                $missingFields[] = "reference_phone_".$i;
            }

            if(!isset($context['reference_email_'.$i]) && $vis->isVisible('reference_email_'.$i))
            {
                $missingFields[] = "reference_email_".$i;
            }

            // If anything is missing, redirect back to the form
            //TODO: re-populate form values after redirect
            if(!empty($missingFields))
            {
                $context['after'] = 'NominationForm';// Set after view to the form
                $context['missing'] = $missingFields;// Add missing fields to context
                $context['form_fail'] = True;// Set form fail

                // Throw exception
                $missingFields = implode(', ', $missing);
                //throw new \nomination\exception\BadFormException('The following fields are missing: ' . $missingFields);
            }

            // TODO: need to check reference emails; should be fully-qualified

            $reference = new Reference($nomination, $first_name, $last_name, $email, $phone, $department, $relationship);
            ReferenceFactory::save($reference);

            // Add each reference to the array of references
            $references[] = $reference;
        }

        /******************************$references
         * Statement / Document Upload *
         ******************************/

        // Make sure the $_FILES array some info on the file we're looking for
        if(!isset($_FILES['statement']) || !is_uploaded_file($_FILES['statement']['tmp_name']))
        {
            //throw new \nomination\exception\BadFormException('Please select a document to upload.');
        }

        // Sanity check on mime type for files the client may still have open
        if($_FILES['statement']['type'] == 'application/octet-stream')
        {
            //throw new \nomination\exception\IllegalFileException('Please save and close all word processors then re-submit file.');
        }

        $doc = new NominationDocument($nomination, 'nominator', 'statement', $_FILES['statement']);

        DocumentFactory::save($doc);

        /***************
         * Send Emails *
        ***************/

        foreach($references as $ref)
        {
            $email = new NewReferenceEmail($nomination, $ref, $emailSettings);
            $email->send();
        }

        // Send emailNewNominatorEmail to nominator, only if the nominator fields are turned on
        $vis = new NominationFieldVisibility();
        if($vis->isVisible('nominator_email'))
        {
            $email = new NewNominatorEmail($nomination, $emailSettings);
            $email->send();
        }

        unset($_SESSION['nomination_fields']);

        \NQ::simple('Nomination', NotificationView::NOMINATION_SUCCESS, 'Form successfully submitted. Email sent.');
    }
}
