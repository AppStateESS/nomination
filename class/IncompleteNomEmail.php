<?php

/**
 * NewNominationEmail
 *
 * Handles sending emails to nominators that have incomplete nominations for
 * the nomination module.
 *
 * @author Chris Detsch
 * @package nomination
 */

 class IncompleteNomEmail extends NominationEmail
 {
   const friendlyName = "Nominators with incomplete nomination";


   public function getMembers()
   {
     $db = new PHPWS_DB('nomination_nomination');
     $db->addColumn('id');
     $db->addWhere('complete', 0);
     $results = $db->select('col');

     if(PHPWS_Error::logIfError($results) || is_null($results))
     {
         throw new DatabaseException('Could not retrieve requested mailing list');
     }

     return $results;
   }

   public function send()
   {
     $list = $this->getMembers();

     foreach ($list as $id)
     {
       $nomination = NominationFactory::getNominationbyId($id);
       $this->sendTo($nomination->getNominatorEmail());
       $this->logEmail($nomination, $nomination->getNominatorEmail(), $id, NOMINATOR);
     }
   }

 }

?>
