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

    public function display(\nomination\Context $context)
    {
        $omnom = new \nomination\NominationFactory();
        $omnom = $omnom->getNominationbyId($context['nomination']);

        $doc = new \nomination\DocumentFactory();
        $doc = $doc->getDocumentById($context['unique_id']);
        $doc->newSendFile($context['unique_id']);
    }
}
