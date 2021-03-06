<?php

namespace nomination\email;

use \nomination\NominationSettings;
use \nomination\EmailLog;
use \nomination\EmailLogFactory;

if (!defined('EMAIL_TEST_FLAG')) {
    define('EMAIL_TEST_FLAG', false);
}

if (EMAIL_TEST_FLAG) {
    require_once PHPWS_SOURCE_DIR . 'mod/nomination/class/FakeSwiftMailer.php';
}

// Setup autoloader for Composer to load SwiftMail via autoload
require_once PHPWS_SOURCE_DIR . 'mod/nomination/inc/defines.php';
require_once PHPWS_SOURCE_DIR . 'mod/nomination/vendor/autoload.php';

/**
 * Abstract class for representing an email to be sent. Provides a
 * central implementaion of message sending/delivery via SwiftMail
 * library. To use, implment a concrete child class, call the child
 * class constructor, then call the send() method.
 *
 * This class could later be abstracted further to use alternate delivery
 * providers (i.e. a transactional email API).
 *
 * @author jbooker
 * @package nomination\email
 */
abstract class Email
{

    // Address info, initialized to empty arrays in constructor
    protected $to;
    protected $cc;
    protected $bcc;
    // From name and address, defaulted to system name and address settings
    protected $fromName;
    protected $fromAddress;
    protected $subject; // Must be set by concrete implementations in buildMessage()
    protected $tpl; // Array of template tags, setup in buildMessage()
    protected $emailSettings; // Instance of NominationSettings class, holds system settings

    /**
     * Constructor
     * Initializses to/cc/bbc arrays to empty. Sets 'from' information via NominationSettings
     *
     * @param nomination\NominationSettings $settings Instance of an NominationSettings class. Available via NominationSettings::getInstance()
     */

    public function __construct(NominationSettings $settings)
    {
        $this->tpl = array();
        $this->to = array();
        $this->cc = array();
        $this->bcc = array();
        $this->emailSettings = $settings;
        // Set a default from address and name, based on system settings
        // Child classes can overwrite these values
        //$this->fromName = $this->emailSettings->getSystemName();
        $this->fromAddress = $this->emailSettings->getEmailFromAddress();
    }

    protected abstract function buildMessage();

    protected abstract function getTemplateFileName();

    protected abstract function logNomEmail($id);

    public function send()
    {
        // Build the message template and to/cc/from fields
        $this->buildMessage();
        // Get the body of the message by processing the template tag array into a template file
        $bodyContent = $this->buildMessageBody($this->getTemplateFileName());
        // Build a SwiftMessage object from member variables, settings, and body content
        $message = $this->buildSwiftMessage($this->to, $this->fromAddress,
                $this->fromName, $this->subject, $bodyContent, $this->cc,
                $this->bcc);
        // Send the SwiftMail message
        $this->sendSwiftMessage($message);
        // Log email into Nomination Database
        $this->logNomEmail();
    }

    protected function buildMessageBody($templateFileName)
    {
        $bodyContent = \PHPWS_Template::process($this->tpl, 'nomination',
                        $templateFileName);
        return $bodyContent;
    }

    /**
     * Performs the email delivery process.
     *
     * @param  string $to
     * @param  string $fromAddress
     * @param  string $fromName
     * @param  string $subject
     * @param  string $content
     * @param  Array $cc
     * @param  Array $bcc
     * @return \Swift_Message if successful.
     */
    protected static function buildSwiftMessage($to, $fromAddress, $fromName,
            $subject, $content, $cc = NULL, $bcc = NULL)
    {
        // Sanity checking
        if (!isset($to) || $to === null) {
            throw new \InvalidArgumentException('\"To\" not set.');
        }
        if (!isset($fromAddress) || $fromAddress === null) {
            throw new \InvalidArgumentException('\"From Address\" not set.');
        }
        if (!isset($subject) || $subject === null) {
            throw new \InvalidArgumentException('\"Subject\" not set.');
        }
        if (!isset($content) || $content === null) {
            throw new \InvalidArgumentException('\"Content\" not set.');
        }
        $message = \Swift_Message::newInstance();

        // Set up Swift Mailer message
        $message->setSubject($subject);
        $message->setFrom(array($fromAddress => $fromName));
        $message->setTo($to);
        $message->setBody($content);
        if (isset($cc)) {
            $message->setCc($cc);
        }
        if (isset($bcc)) {
            $message->setBcc($bcc);
        }
        return $message;
    }

    protected static function sendSwiftMessage(\Swift_Message $message)
    {
        //Set up Swift Mailer delivery
        $transport = \Swift_SmtpTransport::newInstance('localhost');
        $mailer = \Swift_Mailer::newInstance($transport);
        // If we're not in test mode, actually send the message
        $mailer->send($message); // send() returns the number of successful recipients. Can be 0, which indicates failure
        self::logEmail($message);
        return true;
    }

    /**
     * Stores the email in file email.log
     *
     * @param  $message
     */
    public static function logEmail(\Swift_Message $message)
    {
        // Log the message to a text file
        $fd = fopen(PHPWS_SOURCE_DIR . 'logs/email.log', "a");
        fprintf($fd, "=======================\n");
        fprintf($fd, "To: %s\n", implode('', array_keys($message->getTo())));
        if ($message->getCc() != null) {
            foreach ($message->getCc() as $address => $name) {
                fprintf($fd, "Cc: %s\n", $address);
            }
        }
        if ($message->getBcc() != null) {
            foreach ($message->getBcc() as $address => $name) {
                fprintf($fd, "Bcc: %s\n", $address);
            }
        }
        fprintf($fd, "From: %s\n", implode('', $message->getFrom()));
        fprintf($fd, "Subject: %s\n", $message->getSubject());
        fprintf($fd, "Content: \n");
        fprintf($fd, "%s\n\n", $message->getBody());
        fclose($fd);
    }

    // Allows EmailLog and SendEmail to grab a list of
    // message types.
    public static function getLists()
    {
        //if you change anything about this array update the below function
        //yes it's hackish but we're "sure" that there will only be 5 lists...
        $lists = array();

        $lists['ALLNOM'] = 'ALLNOM';
        $lists['NOMCPL'] = 'NOMCPL';
        $lists['NOMINC'] = 'Nomination incomplete';
        $lists['REFNON'] = 'Reference upload required';
        $lists['NOMINE'] = 'NOMINE';

        // These must be here for EmailLog to properly work
        // These later become unset in the SendEmail class.
        $lists['NEWNOM'] = 'Nominator';
        $lists['NEWREF'] = 'Reference';

        return $lists;
    }

}
