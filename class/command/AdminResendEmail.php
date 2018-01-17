<?php

namespace nomination\command;

use nomination\Command;
use nomination\Context;
use nomination\UserStatus;
use nomination\EmailMessage;
use nomination\NominationSettings;

// For testing email. Leave commented out.
//require_once PHPWS_SOURCE_DIR . 'mod/nomination/class/FakeSwiftMailer.php';

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
\PHPWS_Core::initModClass('nomination', 'view/AjaxMessageView.php');

class AdminResendEmail extends Command
{

    public $from;
    public $list;
    public $subject;
    public $message;

    public function getRequestVars()
    {
        $vars = array('action' => 'ResendEmail');
        return $vars;
    }

    public function execute(Context $context)
    {
        if (!UserStatus::isAdmin()) {
            throw new PermissionException('Administrative resend not allowed');
        }

        if (!isset($context['id'])) {
            \PHPWS_Core::initModClass('nomination',
                    'exception/ContextException.php');
            throw new ContextException('Context ID expected.');
        }

        $settings = NominationSettings::getInstance();
        $from = $settings->getEmailFromAddress();
        // Load the email that needs to be resent
        $message = new EmailMessage($context['id']);

        if ($message->id == 0 || $message == null) {
            \PHPWS_Core::initModClass('nomination',
                    'exception/DatabaseException.php');
            throw new DatabaseException('Error occurred loading email message from database.');
        }
        $db = \phpws2\Database::getDB();
        if ($message->receiver_type == 'NTR') {
            $tbl = $db->addTable('nomination_nomination');
            $tbl->addFieldConditional('id', $message->nominee_id);
            $tbl->addField('nominator_email');
        } elseif ($message->receiver_type == 'REF') {
            $tbl = $db->addTable('nomination_reference');
            $tbl->addFieldConditional('id', $message->receiver_id);
            $tbl->addField('email');
        } else {
            throw new \Exception('Unknown receiver type in admin resend email.');
        }
        $to_address = $db->selectColumn();
        $transport = \Swift_MailTransport::newInstance();
        $swift = \Swift_Message::newInstance();
        $swift->setSubject($message->subject);
        $swift->setFrom($from);
        $swift->setTo($to_address);
        $swift->setBody($message->message);
        $mailer = \Swift_Mailer::newInstance($transport);
        $mailer->send($swift);
        echo 'true';
        exit();
    }

}
