<?php

namespace nomination\view;

/**
 * DownloadFile
 *
 *   Sends a file to the client... special thanks to Jeremy for the
 * download examples.
 *
 * @author Daniel West <dwest at tux dot appstate dot edu>
 * @package nomination
 */
class DownloadFile extends \nomination\View
{

    public $unique_id;
    public $nomination;

    public function getRequestVars()
    {
        $vars = array('view' => 'DownloadFile');

        if (isset($this->unique_id)) {
            $vars['unique_id'] = $this->unique_id;
        }

        if (isset($this->nomination)) {
            $vars['nomination'] = $this->nomination;
        }

        return $vars;
    }

    public function display(\nomination\Context $context)
    {
        if (isset($context['reference'])) {
            $doc = new \nomination\DocumentFactory;
            $document = $doc->getReferenceDocument($context['reference']);
            
        } elseif (isset($context['nomination'])) {
            $nominationFactory = new \nomination\NominationFactory();
            $nominationFactory = $nominationFactory->getNominationbyId($context['nomination']);
            $doc = new \nomination\DocumentFactory();
            $document = $doc->getNominatorDocument($context['nomination']);
        } else {
            throw new \Exception('Unknown document type');
        }

        $fileDirectory = \PHPWS_Settings::get('nomination', 'file_dir');

        $documentPath = $fileDirectory . $document->getFilePath() . $document->getFileName();
        $mimeType = $document->getMimeType();
        $originalName = $document->getOrigFileName();

        header("Content-type: $mimeType");
        header('Content-Disposition: attachment; filename="' . $originalName . '"');
        readfile($documentPath);
        exit;
    }

}
