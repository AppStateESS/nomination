<?php

  /**
   * AjaxMessageView
   *
   *   JSON encodes whatever is set in the message field of the 
   * context.
   *
   * @author Daniel West <dwest at tux dot appstate dot edu>
   * @package nomination
   */
PHPWS_Core::initModClass('nomination', 'View.php');

class AjaxMessageView extends \nomination\View {
    protected $message;

    public function getRequestVars()
    {
        $vars = array('view'=>'AjaxMessageView');
        if(isset($this->message)){
            $vars['message'] = $this->message;
        }

        return $vars;
    }

    public function display(Context $context)
    {
        echo json_encode($context['message']);
        exit;
    }

    public function setmessage($message)
    {
        $this->message = $message;
    }
}
?>
