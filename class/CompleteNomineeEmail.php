<?php

/**
 * CompleteNomineeEmail
 *
 * Handles sending emails to nominees whos nomination is complete for the nomination module.
 *
 * @author Chris Detsch
 * @package nomination
 */

 class CompleteNomineeEmail extends NominationEmail
 {
   const friendlyName = "New Nomination";

   public function getMembers()
   {
     $db = new PHPWS_DB('nomination_nomination');
     $db->addColumn('nomination_nomination.email');
     $db->addWhere('complete', 1);
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
       $nomination = NominationFactory::getNominationId($id);
       $this->sendTo($nomination->getEmail());
       $this->logEmail($nomination, $nomination->getEmail(), $id, NOMINEE);
     }
   }

 }

?>
