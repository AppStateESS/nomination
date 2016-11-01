<?php
namespace nomination;

/**
 * EmailLog
 *
 * Model class for representing an EmailLog.
 *
 * @author Chris Detsch
 * @package nomination
 */
class EmailLog
{
    public $id;
    public $nominee_id;
    public $message;
    public $message_type;
    public $subject;
    public $receiver_id;
    public $receiver_type;
    public $sent_on;

    public function __construct($id, $nominee_id, $message, $message_type, $subject,
                                $receiver_id, $receiver_type, $sent_on)
    {
      $this->id = $id;
      $this->nominee_id = $nominee_id;
      $this->message = $message;
      $this->message_type = $message_type;
      $this->subject = $subject;
      $this->receiver_id = $receiver_id;
      $this->receiver_type = $receiver_type;
      $this->sent_on = $sent_on;
    }

    /**
     * Getters
     */
    public function getId()
    {
      return $this->id;
    }

    public function getNomineeId()
    {
      return $this->nominee_id;
    }

    public function getMessage()
    {
      return $this->message;
    }

    public function getMessageType()
    {
      return $this->message_type;
    }

    public function getSubject()
    {
      return $this->subject;
    }

    public function getReceiverId()
    {
      return $this->receiver_id;
    }

    public function getReceiverType()
    {
      return $this->receiver_type;
    }

    public function getSentOn()
    {
      return $this->sent_on;
    }

    /**
     * Setters
     */
    public function setId($id)
    {
      $this->id = $id;
    }

    public function setNomineeId($nomineeId)
    {
      $this->nominee_id = $nomineeId;
    }

    public function setMessage($message)
    {
      $this->message = $message;
    }

    public function setMessageType($messageType)
    {
      $this->message_type = $messageType;
    }

    public function setSubject($subject)
    {
      $this->subject = $subject;
    }

    public function setReceiverId($receiverId)
    {
      $this->receiver_id = $receiverId;
    }

    public function setReceiverType($receiverType)
    {
      $this->receiver_type = $receiverType;
    }

    public function setSentOn($sentOn)
    {
      $this->sent_on = $sentOn;
    }

    // Row tags for DBPager
    public function rowTags() {
        $tpl             = array();
        $tpl['ID']     = $this->getId();
        $nomination    = NominationFactory::getNominationbyId($this->getNomineeId());
        $tpl['NOMINEE'] = $nomination->getNomineeLink();
        $tpl['MESSAGE'] = $this->getMessage();
        $msgTypeList = NominationEmail::getLists();
        $tpl['MESSAGE_TYPE'] = $msgTypeList[$this->getMessageType()];
        $tpl['SUBJECT'] = $this->getSubject();
        if($this->getReceiverType() === 'REF')
        {
          $ref = ReferenceFactory::getReferenceById($this->getReceiverId());
          $tpl['RECEIVER'] = $ref->getReferenceLink();
          $tpl['RECEIVER_TYPE'] = 'Reference';
        }
        else if($this->getReceiverType() === 'NTR')
        {
          $nomination = NominationFactory::getNominationbyId($this->getReceiverId());
          $tpl['RECEIVER'] = $nomination->getNominatorLink();
          $tpl['RECEIVER_TYPE'] = 'Nominator';
        }
        else if($this->getReceiverType() === 'NEE')
        {
          $nomination = NominationFactory::getNominationbyId($this->getReceiverId());
          $tpl['RECEIVER'] = $nomination->getNomineeLink();
          $tpl['RECEIVER_TYPE'] = 'Nominee';
        }

        $tpl['SENT_ON'] = date("m/d/Y h:i a",$this->getSentOn());
        return $tpl;
    }
}
