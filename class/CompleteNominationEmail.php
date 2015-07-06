<?php

/**
 * CompleteNominationEmail
 *
 * Handles sending emails to nominators with complete nomination for the
 * nomination module.
 *
 * @author Chris Detsch
 * @package nomination
 */
 class CompleteNominationEmail extends NominationEmail
 {
   const friendlyName = "Nominators with complete nomination";

   public function getMembers()
   {
     $period = Period::getCurrentPeriod();
     $period_id = $period->getId();
     $db = new PHPWS_DB('nomination_nomination');
     $db->addColumn('id');
     $db->addWhere('complete', 1);
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
       $nomination = NominationFactory::getNominationbyId($id);

       if(!isset($nomination))
       {
         throw new NominationException('The given reference is null, unique id = ' . $id);
       }

       $this->sendTo($nomination->getNominatorEmail());
       $this->logEmail($nomination, $nomination->getNominatorEmail(), $id, NOMINATOR);
     }
   }

 }
