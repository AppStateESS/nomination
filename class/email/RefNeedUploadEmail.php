<?php
namespace nomination\email;
use \nomination\view\NotificationView;
use \nomination\email\GenericEmail;
use \nomination\Period;
use \nomination\ReferenceFactory;
/**
* RefNeedUploadEmail
*
* Handles sending emails to references that still need to upload their reference
* for the nomination module.
*
* @author Chris Detsch
* @package nomination
*/

class RefNeedUploadEmail extends GenericEmail
{
    public function getMembers()
    {
        $period = Period::getCurrentPeriod();
        $period_id = $period->getId();
        $db = new \PHPWS_DB('nomination_nomination');
        $db->addTable('nomination_reference');
        $db->addColumn('nomination_reference.id');
        $db->addWhere('nomination_nomination.complete', 0);
        $db->addWhere('nomination_nomination.id', 'nomination_reference.nomination_id');
        $db->addWhere('nomination_reference.doc_id', 'NULL');
        $db->addWhere('period', $period_id);
        $results = $db->select('col');

        if(\PHPWS_Error::logIfError($results)){
            throw new exception\DatabaseException('Could not retrieve requested mailing list');
        }

        $list = $this->format($results);

        return $list;
    }

    public function format($list)
    {
      $nomList = array();

      foreach ($list as $id)
      {
          $reference = ReferenceFactory::getReferenceById($id);

          if(!isset($reference))
          {
              throw new NominationException('The given reference is null, id = ' . $id);
          }

          $nomList[] = $reference->getEmail();
      }

      return $nomList;
    }
/*
    public function send()
    {
        $list = $this->getMembers();

        if($list === null){
            \NQ::simple('nomination', NotificationView::NOMINATION_WARNING, 'There was no one in that email list.');
            return;
        }

        foreach ($list as $id)
        {
            $reference = ReferenceFactory::getReferenceById($id);

            if(!isset($reference))
            {
                throw new NominationException('The given reference is null, id = ' . $id);
            }

            $nomination = NominationFactory::getNominationbyId($reference->getNominationId());

            if(!isset($nomination))
            {
                throw new NominationException('The given nomination is null, id = ' . $reference->getNominationId());
            }

            $this->sendTo($reference->getEmail());
            $this->logEmail($nomination, $reference->getEmail(), $id, REFERENCE);
        }
    }
*/
}
