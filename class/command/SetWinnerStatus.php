<?php

  /**
   * SetWinnerStatus
   *
   * Set a given nomination to winner/loser.
   * Do not allow setting status if nomination isn't
   * for current period.
   *
   * @author Robert Bost <bostrt at tux dot appstate dot edu>
   */

PHPWS_Core::initModClass('nomination', 'Command.php');
PHPWS_Core::initModClass('nomination', 'view/AjaxMessageView.php');
PHPWS_Core::initModClass('nomination', 'Nomination.php');
PHPWS_Core::initModClass('nomination', 'NominationFactory.php');
PHPWS_Core::initModClass('nomination', 'Period.php');


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

        if(!isset($nomination))
        {
          throw new NominationException('The given nomination is null, id = ' . $context['id']);
        }

        $db = new PHPWS_DB('nomination_period');
        $db->addWhere('id', $nomination->getPeriod());
        $period = $db->select('row');

        if ($period['year'] == Period::getCurrentPeriodYear()) {
            $nomination->setWinner($status);
        } else {
            $context['after']->setMessage(False);
            return;
        }

        try {
            $factory->save($nomination);
            $context['after']->setMessage(True);
        } catch (DatabaseException $e) {
            $context['after']->setMessage(False);
        }
    }
}
