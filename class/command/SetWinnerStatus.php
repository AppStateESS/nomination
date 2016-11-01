<?php
namespace nomination\command;

  /**
   * SetWinnerStatus
   *
   * Set a given nomination to winner/loser.
   * Do not allow setting status if nomination isn't
   * for current period.
   *
   * @author Robert Bost <bostrt at tux dot appstate dot edu>
   */

use \nomination\Command;
use \nomination\view\AjaxMessageView;
use \nomination\Nomination;
use \nomination\NominationFactory;
use \nomination\Period;
use \nomination\Context;
use \nomination\UserStatus;

class SetWinnerStatus extends Command
{
    public function getRequestVars()
    {
        return array('action' => 'SetWinnerStatus');
    }

    public function execute(Context $context)
    {
        if(!UserStatus::isAdmin()){
            throw new PermissionException('You are not allowed to do this!');
        }

        $context['after'] = new AjaxMessageView();
        $status = $context['status'];
        $factory = new NominationFactory();
        $nomination = $factory->getNominationById($context['id']);

        if(!isset($nomination)) {
            throw new NominationException('The given nomination is null, id = ' . $context['id']);
        }

        $db = new \PHPWS_DB('nomination_period');
        $db->addWhere('id', $nomination->getPeriod());
        $period = $db->select('row');

        if ($period['year'] == Period::getCurrentPeriodYear()) {
            if($status === 'true'){
                $win = '1';
            } else {
                $win = '0';
            }
            $nomination->setWinner($win);
        } else {
            $context['after']->setMessage(false);
            return;
        }

        try {
            $factory->save($nomination);
            $context['after']->setMessage(true);
        } catch (DatabaseException $e) {
            $context['after']->setMessage(talse);
        }
    }
}
