<?php
namespace nomination\command;

/**
 * DoEmail
 *
 *   Actually send emails, based on what type of message it is.
 *
 * @author Daniel West <dwest at tux dot appstate dot edu>
 * @author Chris Detsch
 * @package nomination
 */

 use \nomination\Command;
 use \nomination\Context;
 use \nomination\NominationEmail;
 use \nomination\UserStatus;
 use \nomination\view\NotificationView;

 use \nomination\email\AllNominatorsEmail;
 use \nomination\email\CompleteNominationEmail;
 use \nomination\email\IncompleteNomEmail;
 use \nomination\email\RefNeedUploadEmail;
 use \nomination\email\CompleteNomineeEmail;

 use \nomination\NominationSettings;

class DoEmail extends Command {

    public $from;
    public $list;
    public $subject;
    public $message;
    public $settings;

    public function getRequestVars()
    {
        $vars = array('action'=>'DoEmail');

        if(isset($this->from)){
            $vars['from'] = $this->from;
        }
        if(isset($this->list)){
            $vars['list'] = $this->list;
        }
        if(isset($this->subject)){
            $vars['subject'] = $this->subject;
        }
        if(isset($this->message)){
            $vars['message'] = $this->message;
        }

        return $vars;
    }

    public function execute(Context $context)
    {

        if(!UserStatus::isAdmin()){
            throw new PermissionException('You are not allowed to do this!');
        }

        $settings = NominationSettings::getInstance();

        try{
            $msgType = $context['list'];

            if($msgType === 'ALLNOM')
            {
              $mail = new AllNominatorsEmail($context['subject'], $context['message'], $msgType, $settings);
              $mail->send();
            }
            else if($msgType === 'NOMCPL')
            {
              $mail = new CompleteNominationEmail($context['subject'], $context['message'], $msgType, $settings);
              $mail->send();
            }
            else if($msgType === 'NOMINC')
            {
              $mail = new IncompleteNomEmail($context['subject'], $context['message'], $msgType, $settings);
              $mail->send();
            }
            else if($msgType === 'REFNON')
            {
              $mail = new RefNeedUploadEmail($context['subject'], $context['message'], $msgType, $settings);
              $mail->send();
            }
            else if($msgType === 'NOMINE')
            {
              $mail = new CompleteNomineeEmail($context['subject'], $context['message'], $msgType, $settings);
              $mail->send();
            }
            \NQ::simple('nomination', NotificationView::NOMINATION_SUCCESS, 'Emails sent');
            $this->redirect();

        } catch(DatabaseException $e){

            \NQ::simple('nomination', NotificationView::NOMINATION_ERROR, $e->getMessage());
        }
    }
}
