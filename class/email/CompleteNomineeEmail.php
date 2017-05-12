<?php
namespace nomination\email;
use \nomination\view\NotificationView;
use \nomination\email\GenericEmail;
use \nomination\Period;
use \nomination\NominationFactory;
use \nomination\EmailLog;
use \nomination\EmailLogFactory;
/**
* CompleteNomineeEmail
*
* Handles sending emails to nominees whos nomination is complete for the nomination module.
*
* @author Chris Detsch
* @package nomination
*/

class CompleteNomineeEmail extends GenericEmail
{
    //const friendlyName = "New Nomination";

    public function getMembers()
    {
        $period = Period::getCurrentPeriod();
        $period_id = $period->getId();
        $db = new \PHPWS_DB('nomination_nomination');
        $db->addColumn('nomination_nomination.email');
        $db->addWhere('complete', 1);
        $db->addWhere('period', $period_id);
        $results = $db->select('col');

        if(\PHPWS_Error::logIfError($results)){
            throw new exception\DatabaseException('Could not retrieve requested mailing list');
        }

        return $results;
    }

    public function getEmailFromID($id)
    {
        $nomination = NominationFactory::getNominationbyId($id);

        if(!isset($nomination)) {
            //throw new NominationException('The given reference is null, unique id = ' . $id);
        }

        return $nomination->getEmail();
    }

    public function logNomEmail($id)
    {
      $nomination = NominationFactory::getNominationbyId($id);

      $message = $this->buildSwiftMessage($this->getEmailFromID($id), $this->fromAddress,
          $this->fromName, $this->subject, $this->message, $this->cc, $this->bcc);


      // Used for the email log within the website
      $messageLog = new EmailLog($nomination->getId(), $message->getBody(),
      $this->messageType, $this->subject, $id, NOMINEE, time());
      EmailLogFactory::save($messageLog);
    }
}
