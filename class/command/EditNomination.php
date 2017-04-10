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
use \nomination\NominationEmail;
use \nomination\Period;
use \nomination\NominationFieldVisibility;
use \nomination\ReferenceEmail;
use \nomination\NominatorEmail;
use \nomination\view\NotificationView;
/**
 * EditNomination
 *
 * Check that all required fields in form are completed, if not
 * redirect back to form with neglected fields highlighted and
 * Notification at top of form.
 * If form checks out then save the new nomination over the old
 *
 * @author Chris Detsch
 */

\PHPWS_Core::initModClass('nomination', 'Command.php');
\PHPWS_Core::initModClass('nomination', 'Context.php');
\PHPWS_Core::initModClass('nomination', 'NominationDocument.php');
\PHPWS_Core::initModClass('nomination', 'view/NominationForm.php');
\PHPWS_Core::initCoreClass('Captcha.php');

class EditNomination extends Command
{
    public $unique_id;

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

    public function getRequestVars()
    {
        $vars = array('action' => 'EditNomination', 'after' => 'ThankYouNominator');

        if(isset($this->unique_id)){
            $vars['unique_id'] = $this->unique_id;
        }

        return $vars;
    }

    public function execute(Context $context)
    {
      $missing = array();
      $entered = array();
      $numReferencesReq = Reference::getNumReferencesReq();
      $nomination = NominationFactory::getByNominatorUniqueId($context['unique_id']);

      // Figure out which fields are required
      \PHPWS_Core::initModClass('nomination', 'NominationFieldVisibility.php');
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

      // Check for missing required fields
      if (isset($_SESSION['redirect']) && $_SESSION['redirect'] == 'true')
        {
            \NQ::simple('nomination', NotificationView::NOMINATION_ERROR, 'Be sure to fill in all required fields.');
            unset($_SESSION['redirect']);
        }
      
      // TODO: Fix this so that it doesn't complain about fields that the user can't fill in.

      foreach($required as $key=>$value){
          if(!isset($context[$value]) || $context[$value] == ""){
              $missing[] = $value;
              $context['after'] = 'NominationForm&unique_id=' . $context['unique_id'];
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
                return;
          } else {
              $entered[$key] = $context[$value];
          }
      }


      // If anything was missing, redirect back to the form
      // TODO: Fix this so that it shows a useful error notification if the user gets the CAPTCHA wrong

     if(!empty($missing) || !Captcha::verify()){

          // Notify the user that they must reselect their file

         // $context['after'] = 'NominationForm';// Set after view to the form
          $context['missing'] = $missing;// Add missing fields to context
          $context['form_fail'] = True;// Set form fail
          // Throw exception
          $missingFields = implode(', ', $missing);
          // TODO
          //throw new \nomination\exception\BadFormException('The following fields are missing: ' . $missingFields);
      }

      $oldNomination = NominationFactory::getByNominatorUniqueId($context['nominator_unique_id']);

      $doc = new DocumentFactory();
      $doc = $doc->getDocumentById($nomination->getId());
      // Needed so that the document save function will update the file if needed.
      $docId = $doc->getId();
      if($doc == null || $_FILES['statement']['size'] > 0 || is_uploaded_file($_FILES['statement']['tmp_name'])){
          // Sanity check on mime type for files the client may still have open
          if($_FILES['statement']['type'] == 'application/octet-stream')
          {
              throw new \nomination\exception\IllegalFileException('Please save and close all word processors then re-submit file.');
          }

          $doc = new NominationDocument($nomination, 'nominator', 'statement', $_FILES['statement']);
          $doc->setId($docId);
          DocumentFactory::save($doc);
      }

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
      $nominatorUniqueId     = $context['nominator_unique_id'];


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

      $nomination->setId($oldNomination->getId());
      NominationFactory::save($nomination);



      /**************
       * References *
       **************/
      $numRefsReq = Reference::getNumReferencesReq();
      $updatedRefsNeedEmail = array();

      for($i = 0; $i < $numRefsReq; $i++)
      {
        $refId = $context['reference_id_'.$i];
        $ref = ReferenceFactory::getReferenceById($refId);

        if(!$vis->isVisible('reference_first_name_' . $i))
        {
          $ref->setFirstName($context['reference_first_name_'.$i]);
        }

        if(!$vis->isVisible('reference_last_name_'.$i))
        {
          $ref->setLastName($context['reference_last_name_'.$i]);
        }

        if(!$vis->isVisible('reference_department_'.$i))
        {
          $ref->setDepartment($context['reference_department_'.$i]);
        }

        if(!$vis->isVisible('reference_phone_'.$i))
        {
          $ref->setPhone($context['reference_phone_'.$i]);
        }

        if(!$vis->isVisible('reference_email_'.$i) && $ref->getEmail() != $context['reference_email_'.$i])
        {
          $ref->setEmail($context['reference_email_'.$i]);
          array_push($updatedRefsNeedEmail, $refId);
        }

        if(!$vis->isVisible('reference_relationship_'.$i))
        {
          $ref->setRelationship($context['reference_relationship_'.$i]);
        }

        ReferenceFactory::save($ref);

      }


      /***************
       * Send Emails *
      ***************/
      foreach($updatedRefsNeedEmail as $refId)
      {
          $ref = ReferenceFactory::getReferenceById($refId);
          ReferenceEmail::updateNomination($ref, $nomination);
      }


      \NQ::simple('Nomination', NotificationView::NOMINATION_SUCCESS, 'Form successfully submitted. Changes made.');


    }
}
