<?php
namespace nomination\email;
use \nomination\view\NotificationView;
use \nomination\email\GenericEmail;
use \nomination\Period;
use \nomination\ReferenceFactory;
use \nomination\NominationFactory;
use \nomination\EmailLog;
use \nomination\EmailLogFactory;
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

        return $results;
    }

    public function getEmailFromID($id)
    {
        $reference = ReferenceFactory::getReferenceById($id);

        if(!isset($reference))
        {
            throw new NominationException('The given reference is null, id = ' . $id);
        }

        return $reference->getEmail();
    }

    public function logNomEmail($id = null)
    {
      $reference = ReferenceFactory::getReferenceById($id);
      $nomination = NominationFactory::getNominationbyId($reference->getNominationId());

      $message = $this->buildSwiftMessage($this->getEmailFromID($id), $this->fromAddress,
          $this->fromName, $this->subject, $this->message, $this->cc, $this->bcc);


      // Used for the email log within the website
      $messageLog = new EmailLog($nomination->getId(), $message->getBody(),
      $this->messageType, $this->subject, $id, REFERENCE, time());
      EmailLogFactory::save($messageLog);
    }
}
