<?php
namespace nomination;
use \nomination\view\NotificationView;
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

    public function send() {
        $list = $this->getMembers();

        if($list === null){
            \NQ::simple('nomination', NotificationView::NOMINATION_WARNING, 'There was no one in that email list.');
            return;
        }

        foreach ($list as $id) {
            $nomination = NominationFactory::getNominationbyId($id);

            if(!isset($nomination)) {
                throw new NominationException('The given nomination is null, id = ' . $id);
            }

            $this->sendTo($nomination->getNominatorEmail());
            $this->logEmail($nomination, $nomination->getNominatorEmail(), $nomination->getId(), NOMINATOR);
        }
    }

}
