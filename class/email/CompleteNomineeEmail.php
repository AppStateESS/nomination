<?php
namespace nomination;
use \nomination\view\NotificationView;
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

        $list = $this->format($results);

        return $list;
    }

    public function format($list)
    {
        $nomList = array();

        if($list === null){
            \NQ::simple('nomination', NotificationView::NOMINATION_WARNING, 'There was no one in that email list.');
            return;
        }

        foreach ($list as $id) {
            $nomination = NominationFactory::getNominationbyId($id);

            if(!isset($nomination)) {
                throw new NominationException('The given reference is null, unique id = ' . $id);
            }

            $nomList[] = $nomination->getEmail();
        }
        return $nomList;
    }
}
