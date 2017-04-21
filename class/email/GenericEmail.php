<?php

namespace nomination;

class GenericEmail extends Email
{
  public $from;
  public $subject;
  public $message;
  public $messageType;

  public function __construct($subject, $message, $msgType)
  {
      $this->subject     = $subject;
      $this->message     = $message;
      $this->messageType = $msgType;
      $this->from        = \PHPWS_Settings::get('nomination', 'email_from_address');
  }

  public function send()
  {
      // Build the message template and to/cc/from fields
      $this->buildMessage();
      // Get the body of the message by processing the template tag array into a template file
      $bodyContent = $this->buildMessageBody($this->getTemplateFileName());
      // Build a SwiftMessage object from member variables, settings, and body content
      $message = $this->buildSwiftMessage($this->to, $this->fromAddress, $this->fromName, $this->subject, $bodyContent, $this->cc, $this->bcc);
      // Send the SwiftMail message
      $this->sendSwiftMessage($message);
  }

}
