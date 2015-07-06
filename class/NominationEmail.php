<?php

/**
 * NominationEmail
 *
 * Handles sending emails to various people for the nomination module.
 *
 * @author Daniel West <dwest at tux dot appstate dot edu>
 * @author Jeremy Booker
 * @author Chris Detsch
 * @package nomination
 */

PHPWS_Core::initModClass('nomination', 'exception/DatabaseException.php');
PHPWS_Core::initModClass('nomination', 'Period.php');
PHPWS_Core::initCoreClass('Mail.php');

// Abbreviated NominationActor names
// Used in DB
define('SHORT_Nominator', 'NMR');
define('SHORT_Nominee',   'NME');
define('SHORT_Reference', 'REF');

// Message types
define('NEWNOM', 'New Nomination');
define('NEWREF', 'New Reference');
define('UPDNOM', 'Updated nomination');
define('REFUPL', 'Reference document upload');
define('NOMDEL', 'Removal request approved');

define('ALLNOM', 'All nominators');
define('NOMCPL', 'Nominators with complete nomination');
define('NOMINC', 'Nominators with incomplete nomination');
define('REFNON', 'References that need to upload');
define('NOMINE', 'Nominees with complete nominations');



abstract class NominationEmail {

    public $from;
    public $list;
    public $subject;
    public $message;
    public $messageType;

    public function __construct($subject, $message, $msgType)
    {
        $this->subject     = $subject;
        $this->message     = $message;
        $this->messageType = $msgType;
        $this->from        = PHPWS_Settings::get('nomination', 'email_from_address');
    }

    public function sendTo($recipientEmail)
    {

        $mail = new PHPWS_Mail;
        $mail->sendIndividually(true);

        $mail->addSendTo($recipientEmail);

        $mail->setFrom($this->from);
        $mail->setSubject($this->subject);
        $mail->setMessageBody($this->message);

        if(!EMAIL_TEST_FLAG){
            $mail->send();
        }

    }

    // Build NominationEmail from EmailMessage and send it.
    public static function sendMessageObj(EmailMessage $msg)
    {
        switch($msg->receiver_type)
        {
            case SHORT_Reference:
                PHPWS_Core::initModClass('nomination', 'Reference.php');
                $db = new PHPWS_DB('nomination_reference');
                $obj = new Reference();
                break;
            case SHORT_Nominator:
                PHPWS_Core::initModClass('nomination', 'Nominator.php');
                $db = new PHPWS_DB('nomination_nominator');
                $obj = new Nominator();
                break;
            case SHORT_Nominee:
                PHPWS_Core::initModClass('nomination', 'Nominee.php');
                $db = new PHPWS_DB('nomination_nominee');
                $obj = new Nominee();
                break;
        }

        // Get the email address.
        $db->addWhere('id', $msg->receiver_id);
        $result = $db->loadObject($obj);

        if(PHPWS_Error::logIfError($result)){
            PHPWS_Core::initModClass('nomination', 'exception/DatabaseException.php');
            throw new DatabaseException($result->toString());
        }
        $obj = array($obj);
        $nominationEmail = new NominationEmail($obj, $msg->subject, $msg->message, $msg->message_type);
        $nominationEmail->send();
    }

    public function logEmail(Nomination $nomination, $recipientEmail, $recipientId, $receiverType)
    {
        // This is all kinds of messed up. Just write it to a log file for now...



        // Log the message to a text file
        $fd = fopen(PHPWS_SOURCE_DIR . 'logs/email.log',"a");
        fprintf($fd, "=======================\n");


        fprintf($fd, "To: %s\n", $recipientEmail);

        fprintf($fd, "From: %s\n", $this->from);
        fprintf($fd, "Subject: %s\n", $this->subject);
        fprintf($fd, "Content: \n");
        fprintf($fd, "%s\n\n", $this->message);

        fclose($fd);



        $now = mktime();

        $message = new EmailLog();


        $message->setNomineeId($nomination->getId());

        $message->setMessage($this->message);
        $message->setMessageType($this->messageType);
        $message->setSubject($this->subject);
        $message->setReceiverId($recipientId);
        $message->setReceiverType($receiverType);
        $message->setSentOn($now);

        EmailLogFactory::save($message);


    }

    public static function getLongMessageType($type)
    {
        switch($type){
            case 'NEWNOM':
                return NEWNOM;
            case 'UPDNOM':
                return UPDNOM;
            case 'REFUPL':
                return REFUPL;
            case 'ALLNOM':
                return ALLNOM;
            case 'NOMCPL':
                return NOMCPL;
            case 'NOMINC':
                return NOMINC;
            case 'REFNON':
                return REFNON;
            case 'NOMINE':
                return NOMINE;
            default:
                return null;
        }
    }

    // TODO: Is there a way to build a constant's name with string
    public static function getAbbrevName($class)
    {
        switch($class){
            case 'Nominator':
                return SHORT_Nominator;
            case 'Reference':
                return SHORT_Reference;
            case 'Nominee':
                return SHORT_Nominee;
        }
    }

    public static function getLists()
    {
        //if you change anything about this array update the below function
        //yes it's hackish but we're "sure" that there will only be 5 lists...
        $lists = array();

        $lists['ALLNOM'] = ALLNOM;
        $lists['NOMCPL'] = NOMCPL;
        $lists['NOMINC'] = NOMINC;
        $lists['REFNON'] = REFNON;
        $lists['NOMINE'] = NOMINE;
        $lists['NEWNOM'] = NEWNOM;
        $lists['NEWREF'] = NEWREF;

        return $lists;
    }

}
