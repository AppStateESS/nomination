<?php
namespace nomination\email;
use \nomination\view\NotificationView;
use \nomination\email\GenericEmail;
use \nomination\Period;
use \nomination\NominationFactory;
use \nomination\EmailLog;
use \nomination\EmailLogFactory;

/**
* AllNominatorsEmail
*
* Handles sending emails to all the nominators for the nomination module.
*
* @author Chris Detsch
* @package nomination
*/

class AllNominatorsEmail extends GenericEmail{
    const friendlyName = "All nominators";

    public function getMembers()
    {
        $period = Period::getCurrentPeriod();
        $period_id = $period->getId();
        $db = new \PHPWS_DB('nomination_nomination');
        $db->addColumn('id');
        $db->addWhere('period', $period_id);
        $results = $db->select('col');

        if(\PHPWS_Error::logIfError($results)) {
            throw new exception\DatabaseException('Could not retrieve requested mailing list');
        }

        return $results;

    }

    public function getEmailFromID($id)
    {

        $nomination = NominationFactory::getNominationbyId($id);

        if(!isset($nomination))
        {
            //throw new NominationException('The given reference is null, unique id = ' . $id);
        }

        return $nomination->getNominatorEmail();
    }

    public function logNomEmail($id)
    {
        $nomination = NominationFactory::getNominationbyId($id);

        $message = $this->buildSwiftMessage($this->getEmailFromID($id), $this->fromAddress,
            $this->fromName, $this->subject, $this->message, $this->cc, $this->bcc);


        // Used for the email log within the website
        $messageLog = new EmailLog($nomination->getId(), $message->getBody(),
        $this->messageType, $this->subject, $id, NOMINATOR, time());
        EmailLogFactory::save($messageLog);
    }

}
