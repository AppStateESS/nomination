<?php

  /**
   * CheckFile
   *
   *   Receives a file type and size and returns either an error
   * message or true to the client via json.
   *
   * @author Daniel West <dwest at tux dot appstate dot edu>
   * @package nomination
   *
   */
PHPWS_Core::initModClass('nomination', 'Command.php');
PHPWS_Core::initModClass('nomination', 'view/AjaxMessageView.php');
PHPWS_Core::initModClass('nomination', 'NominationDocument.php');

class CheckFile extends Command {

    public function getRequestVars(){
        return array();
    }

    public function execute(Context $context){
        $context['after'] = new AjaxMessageView;

        $types = NominationDocument::getSupportedMimeTypes();
        if(!in_array($context['type'], $types)){
            $context['after']->setMessage('Invalid file type!');
        }/* elseif($context['size'] > ini_get('upload_max_filesize')){
            $context['after']->setMessage('File too large!');
        } */else {
            $context['after']->setMessage(True);
        }

    }
}
?>
