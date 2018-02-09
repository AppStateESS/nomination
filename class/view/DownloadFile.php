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
        $omnom = new \nomination\NominationFactory();
        $omnom = $omnom->getNominationbyId($context['nomination']);

        $doc = new \nomination\DocumentFactory();
        $document = $doc->getNominatorDocument($context['nomination']);
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
