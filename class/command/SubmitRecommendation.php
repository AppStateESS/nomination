<?php
  /**
   * SubmitRecommendation
   *
   *  Save the letter of recommendation submitted by a Reference.
   *
   * @author Daniel West <dwest at tux dot appstate dot edu>
   * @package nomination
   */

PHPWS_Core::initModClass('nomination', 'Command.php');
PHPWS_Core::initModClass('nomination', 'NominationFactory.php');
PHPWS_Core::initModClass('nomination', 'NominationDocument.php');
PHPWS_Core::initModClass('nomination', 'DocumentFactory.php');
PHPWS_Core::initModClass('nomination', 'ReferenceFactory.php');

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
        if(!isset($ref))
        {
          throw new NominationException('The given reference is null, unique id = ' . $context['unique_id']);
        }

        // Get the corresponding nomination
        $nomination = NominationFactory::getNominationById($ref->getNominationId());
        if(!isset($nomination))
        {
          throw new NominationException('The given nomination is null, id = ' . $ref->getNominationId());
        }

        PHPWS_Core::initModClass('nomination', 'exception/IllegalFileException.php');

        // Make sure the $_FILES array some info on the file we're looking for
        if(!isset($_FILES['recommendation']) || !is_uploaded_file($_FILES['recommendation']['tmp_name'])){
            PHPWS_Core::initModClass('nomination', 'exception/BadFormException.php');
            throw new BadFormException('Please select a document to upload.');
        }

        // Sanity check on mime type for files the client may still have open
        if($_FILES['recommendation']['type'] == 'application/octet-stream'){
            throw new IllegalFileException('Please save and close all word processors then re-submit file.');
        }

        $doc = new NominationDocument($nomination, 'reference', 'recommendation', $_FILES['recommendation']);
        DocumentFactory::save($doc);


        // Save the ID of the document with the Reference object
        $ref->setDocId($doc->getId());

        ReferenceFactory::save($ref);


        // Check if nomination is completed now...
        // TODO
        $nomination->checkCompletion();

        // Send notification email
        // TODO

        $ref = Reference::getByUniqueId($context['unique_id']);
        ReferenceEmail::uploadDocument($ref);

        NQ::simple('nomination', NOMINATION_SUCCESS, 'Thank you!');
    }
}
