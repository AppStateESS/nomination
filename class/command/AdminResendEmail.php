<?php
namespace nomination\command;

  /**
   * AdminResendEmail
   *
   * Resend an email to reference, nominator, or nominee.
   * Admins can resend to anyone.
   *
   * This class is likely no longer in use, uses some classes that
   * no longer exist.
   *
   * @author Robert Bost <bostrt at tux dot appstate dot edu>
   */

PHPWS_Core::initModClass('nomination', 'Command.php');
PHPWS_Core::initModClass('nomination', 'Context.php');
PHPWS_Core::initModClass('nomination', 'view/AjaxMessageView.php');
PHPWS_Core::initModClass('nomination', 'PLM_Email.php');
PHPWS_Core::initModClass('nomination', 'EmailMessage.php');

class AdminResendEmail extends Command
{

    public function getRequestVars()
    {
        $vars = array('action' => 'ResendEmail');

        return $vars;
    }

    public function execute(Context $context)
    {
        if(!UserStatus::isAdmin()){
            throw new PermissionException('You are not allowed to do that!');
        }

        if(!isset($context['id'])){
            PHPWS_Core::initModClass('nomination', 'exception/ContextException.php');
            throw new ContextException('ID expected.');
        }

        // Load the email that needs to be resent
        $message = new EmailMessage($context['id']);

        if($message->id == 0 || $message == null){
            PHPWS_Core::initModClass('nomination', 'expcetion/DatabaseException.php');
            throw new DatabaseException('Error occured loading email message from database.');
        }

        PLM_Email::sendMessageObj($message);


        if(isset($context['ajax'])){
            $context['after'] = new AjaxMessageView();
            $context['after']->setMessage(true);
        }

        NQ::simple('nomination', NotificationView::NOMINATION_SUCCESS, 'Email sent.');
    }
}
