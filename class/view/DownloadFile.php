<?php

/**
 * DownloadFile
 *
 *   Sends a file to the client... special thanks to Jeremy for the
 * download examples.
 *
 * @author Daniel West <dwest at tux dot appstate dot edu>
 * @package nomination
 */

PHPWS_Core::initModClass('nomination', 'View.php');
PHPWS_Core::initModClass('nomination', 'NominationDocument.php');
PHPWS_Core::initModClass('nomination', 'NominationFactory.php');
PHPWS_Core::initModClass('nomination', 'DocumentFactory.php');

class DownloadFile extends \nomination\View {
    public $unique_id;
    public $nomination;

    public function getRequestVars()
    {
        $vars = array('view'=>'DownloadFile');

        if(isset($this->unique_id)){
            $vars['unique_id'] = $this->unique_id;
        }

        if(isset($this->nomination)){
            $vars['nomination'] = $this->nomination;
        }

        return $vars;
    }

    public function display(Context $context)
    {
        $omnom = new NominationFactory();
        $omnom = $omnom->getNominationbyId($context['nomination']);

        $doc = new DocumentFactory();
        $doc = $doc->getDocumentById($context['unique_id']);
        $doc->newSendFile($context['unique_id']);
    }
}
