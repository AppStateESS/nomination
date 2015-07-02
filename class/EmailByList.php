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

     public function send()
     {
       $list = $this->list;


       foreach ($list as $id)
       {
         if($this->messageType === 'NEWREF')
         {
           $ref = ReferenceFactory::getReferenceById($id);
           $nomination = NominationFactory::getNominationbyId($ref->getNominationId());
           $this->sendTo($ref->getEmail());
           $this->logEmail($nomination, $ref->getEmail(), $id, 'REF');
         }
         else if($this->messageType === 'NEWNOM')
         {
           $nomination = NominationFactory::getNominationbyId($id);

           $this->sendTo($nomination->getNominatorEmail());
           $this->logEmail($nomination, $nomination->getEmail(), $id, 'NTR');
         }
       }
     }

   }


?>
