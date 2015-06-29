<?php

  /**
   * A class for sending emails based on a premade list
   *
   *
   * @author Chris Detsch
   * @package nomination
   */
   class EmailByList extends NominationEmail
   {

     public function __construct($list, $subject, $message, $msgType)
     {
         $this->list    = $list;
         $this->subject = $subject;
         $this->message = $message;
         $this->messageType = $msgType;
         $this->from    = PHPWS_Settings::get('nomination', 'email_from_address');
     }

   }


?>
