<?php
namespace nomination\command;
  /**
   * SubmitRecommendation
   *
   *  Save the letter of recommendation submitted by a Reference.
   *
   * @author Daniel West <dwest at tux dot appstate dot edu>
   * @package nomination
   */

use nomination\Command;
use nomination\Context;
use nomination\NominationFactory;
use nomination\NominationDocument;
use nomination\DocumentFactory;
use nomination\ReferenceFactory;
use nomination\view\NotificationView;
use nomination\NominationSettings;
use nomination\email\NewReferenceEmail;

class SubmitRecommendation extends Command {

    public function getRequestVars()
    {
        $vars = array('action'=>'SubmitRecommendation',
                      'after' =>'ThankYouReference');

        return $vars;
    }

    public function execute(Context $context)
    {
        // Get this reference
        $ref = ReferenceFactory::getByUniqueId($context['unique_id']);
        if(!isset($ref)) {
          throw new NominationException('The given reference is null, unique id = ' . $context['unique_id']);
        }

        // Get the corresponding nomination
        $nomination = NominationFactory::getNominationById($ref->getNominationId());
        if(!isset($nomination)) {
          throw new NominationException('The given nomination is null, id = ' . $ref->getNominationId());
        }

        \PHPWS_Core::initModClass('nomination', 'exception/IllegalFileException.php');

        // Make sure the $_FILES array some info on the file we're looking for
        if(!isset($_FILES['recommendation']) || !is_uploaded_file($_FILES['recommendation']['tmp_name'])){
            \NQ::simple('nomination', NotificationView::NOMINATION_ERROR, 'Please select a document to upload.');
            $context['after'] = 'ReferenceForm&unique_id=' . $context['unique_id'];
            return;
        }

        // Sanity check on mime type for files the client may still have open
        if($_FILES['recommendation']['type'] == 'application/octet-stream'){
            \NQ::simple('nomination', NotificationView::NOMINATION_ERROR, 'Please save and close the document you are trying to upload and then try again.');
            $context['after'] = 'ReferenceForm&unique_id=' . $context['unique_id'];
            return;
        }

        $doc = null;

        try {
            $doc = new NominationDocument($nomination, 'reference', 'recommendation', $_FILES['recommendation']);
            DocumentFactory::save($doc);

            // Save the ID of the document with the Reference object
            $ref->setDocId($doc->getId());
        } catch(\Exception $e){
            \NQ::simple('nomination', NotificationView::NOMINATION_ERROR, 'The file you submited is not the correct type of file. We can only accept .doc, .docx, and .pdf files.');
            $context['after'] = 'ReferenceForm&unique_id=' . $context['unique_id'];
            return;
        }

        ReferenceFactory::save($ref);

        // Check if nomination is completed now...
        if ($nomination->checkCompletion()){
            $nomination->setComplete(true);
            NominationFactory::save($nomination);
        }

        // Send notification email
        $settings = NominationSettings::getInstance();
        $referenceEmail = new NewReferenceEmail($nomination, $ref, $settings);
        $referenceEmail->send();


        \NQ::simple('nomination', NotificationView::NOMINATION_SUCCESS, 'Thank you!');
    }
}
