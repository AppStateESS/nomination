<?php

namespace nomination\email;

abstract class GenericEmail extends Email
{
  public $fromAddress;
  public $subject;
  public $message;
  public $messageType;
  public $list;

  public function __construct($subject, $message, $msgType, NominationSettings $settings)
  {
      $this->emailSettings = $settings;

      $this->subject     = $subject;
      $this->message     = $message;
      $this->messageType = $msgType;
      $this->fromAddress = $this->emailSettings->getEmailFromAddress();
      $this->fromName    = $this->emailSettings->getSignatureForEmail();
  }

  protected abstract function getMembers();

  //Override email send()
  public function send()
  {
      // Build the message template and to/cc/from fields
      $this->buildMessage();

      // Get the body of the message by processing the template tag array into a template file
      //$bodyContent = $this->buildMessageBody($this->getTemplateFileName());
      // ALREADY MADE FORM $message

      foreach ($this->list as $emailTo) {
        // Build a SwiftMessage object from member variables, settings, and body content
        $message = $this->buildSwiftMessage($emailTo, $this->fromAddress,
            $this->fromName, $this->subject, $message, $this->cc, $this->bcc);
        // Send the SwiftMail message
        $this->sendSwiftMessage($message);
      }
  }

  public function buildMessage()
  {
    // Who to send emails to
    $this->list = getMembers();
  }

  public function getTemplateFileName()
  {
    // Does nothing, no template needed for generic emails.
    // Satisfies email abstract funtion
  }

}
