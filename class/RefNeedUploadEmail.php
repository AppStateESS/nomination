<?php

/**
 * RefNeedUploadEmail
 *
 * Handles sending emails to references that still need to upload their reference
 * for the nomination module.
 *
 * @author Chris Detsch
 * @package nomination
 */

 class RefNeedUploadEmail extends NominationEmail
 {
   const friendlyName = "References that need to upload";

   public function getMembers()
   {
     $period = Period::getCurrentPeriod();
     $period_id = $period->getId();
     $db = new PHPWS_DB('nomination_nomination');
     $db->addTable('nomination_reference');
     $db->addColumn('nomination_reference.id');
     $db->addWhere('nomination_nomination.complete', 0);
     $db->addWhere('nomination_nomination.id', 'nomination_reference.nomination_id');
     $db->addWhere('nomination_reference.doc_id', 'NULL');
     $db->addWhere('period', $period_id);
     $results = $db->select('col');

     if(PHPWS_Error::logIfError($results) || is_null($results)){
         throw new DatabaseException('Could not retrieve requested mailing list');
     }

     return $results;
   }

   public function send()
   {
     $list = $this->getMembers();

     foreach ($list as $id)
     {
       $reference = ReferenceFactory::getReferenceById($id);

       $nomination = NominationFactory::getNominationbyId($reference->getNominationId());
       $this->sendTo($reference->getEmail());
       $this->logEmail($nomination, $reference->getEmail(), $id, REFERENCE);
     }
   }

 }

?>
