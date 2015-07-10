<?php

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

PHPWS_Core::initModClass('nomination', 'Command.php');
PHPWS_Core::initModClass('nomination', 'Context.php');

PHPWS_Core::initModClass('nomination', 'Nomination.php');
PHPWS_Core::initModClass('nomination', 'NominationFactory.php');
PHPWS_Core::initModClass('nomination', 'view/NominationForm.php');
PHPWS_Core::initModClass('nomination', 'NominationDocument.php');
PHPWS_Core::initModClass('nomination', 'DocumentFactory.php');

PHPWS_Core::initModClass('nomination', 'Reference.php');
PHPWS_Core::initModClass('nomination', 'ReferenceFactory.php');

PHPWS_Core::initModClass('nomination', 'NominationEmail.php');

PHPWS_Core::initModClass('nomination', 'Period.php');

PHPWS_CORE::initCoreClass('Captcha.php');

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
				    'nominator_address');

    public function execute(Context $context)
    {
        $missing = array();
        $entered = array();
        $numReferencesReq = Reference::getNumReferencesReq();



        // Figure out which fields are required
        PHPWS_Core::initModClass('nomination', 'NominationFieldVisibility.php');
        $vis = new NominationFieldVisibility();

        $required = array();
        foreach(self::$requiredFields as $field) {
            if($vis->isVisible($field))
            {
            	$required[] = $field;
            }
        }

        for($i = 0; $i < $numReferencesReq; $i++)
        {
          array_push($required, 'reference_first_name_'.$i);
          array_push($required, 'reference_last_name_'.$i);
          array_push($required, 'reference_phone_'.$i);
          array_push($required, 'reference_email_'.$i);
        }
        /*****************
         * Check  fields *
        *****************/

        // Check for missing required fields
        foreach($required as $key=>$value){
            if(!isset($context[$value]) || $context[$value] == ""){
                $missing[] = $value;
            } else {
                $entered[$key] = $context[$value];
            }
        }
        // Check for a "statement" file upload, if required
        if($vis->isVisible('statement')) {
            if($_FILES['statement']['error'] != UPLOAD_ERR_OK){
                PHPWS_Core::initModClass('nomination', 'exception/BadFormException.php');
                $context['after'] = 'NominationForm';// Set after view to the form
                $context['form_fail'] = True;// Set form fail

                $msg = 'Missing statement';

                if(!empty($missing)){
                    // There are other fields missing
                    $msg .= ' and some other fields';
                }
                $missing[] = 'statement';
                $context['missing'] = $missing;// Add missing fields to context
                throw new BadFormException($msg);
            }
        }

        // If anything was missing, redirect back to the form
        if(!empty($missing) || !Captcha::verify()){
            // Notify the user that they must reselect their file
            $missing[] = 'statement';

            $context['after'] = 'NominationForm';// Set after view to the form
            $context['missing'] = $missing;// Add missing fields to context
            $context['form_fail'] = True;// Set form fail

            // Throw exception
            PHPWS_Core::initModClass('nomination', 'exception/BadFormException.php');
            $missingFields = implode(', ', $missing);
            throw new BadFormException('The following fields are missing: ' . $missingFields);
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
        $nomineeEmail       = $context['nominee_email'] . '@appstate.edu';
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
        $nominatorEmail        = $context['nominator_email'] . '@appstate.edu';
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
                PHPWS_Core::initModClass('nomination', 'exception/BadFormException.php');
                $missingFields = implode(', ', $missing);
                throw new BadFormException('The following fields are missing: ' . $missingFields);
            }

            // TODO: need to check reference emails; should be fully-qualified

            $reference = new Reference($nomination, $first_name, $last_name, $email, $phone, $department, $relationship);
            ReferenceFactory::save($reference);

            // Add each reference to the array of references
            $references[] = $reference;
        }

        /******************************
         * Statement / Document Upload *
         ******************************/
        PHPWS_Core::initModClass('nomination', 'exception/IllegalFileException.php');

        // Make sure the $_FILES array some info on the file we're looking for
        if(!isset($_FILES['statement']) || !is_uploaded_file($_FILES['statement']['tmp_name']))
        {
            PHPWS_Core::initModClass('nomination', 'exception/BadFormException.php');
            throw new BadFormException('Please select a document to upload.');
        }

        // Sanity check on mime type for files the client may still have open
        if($_FILES['statement']['type'] == 'application/octet-stream')
        {
            throw new IllegalFileException('Please save and close all word processors then re-submit file.');
        }

        $doc = new NominationDocument($nomination, 'nominator', 'statement', $_FILES['statement']);

        DocumentFactory::save($doc);

        /***************
         * Send Emails *
        ***************/

        foreach($references as $ref)
        {
            ReferenceEmail::newNomination($ref, $nomination);
        }

        // Send email to nominator, only if the nominator fields are turned on
        PHPWS_Core::initModClass('nomination', 'NominationFieldVisibility.php');
        $vis = new NominationFieldVisibility();
        if($vis->isVisible('nominator_email'))
        {
            NominatorEmail::newNomination($nomination);
        }

        NQ::simple('Nomination', NOMINATION_SUCCESS, 'Form successfully submitted. Email sent.');
    }
}
