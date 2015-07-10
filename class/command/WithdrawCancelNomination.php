<?php

  /**
   * WithdrawCancelNomination
   *
   * Withdraw a request to remove a nomination.
   * Removes from CancelQueue.
   *
   * @author Robert Bost <bostrt at tux dot appstate dot edu>
   */

PHPWS_Core::initModClass('nomination', 'Command.php');
PHPWS_Core::initModClass('nomination', 'CancelQueue.php');
PHPWS_Core::initModClass('nomination', 'Nomination.php');

class WithdrawCancelNomination extends Command
{
    public $unique_id;

    public function getRequestVars()
    {
        $vars = array('action' => 'WithdrawCancelNomination', 'after' => 'RequestWithdrawn');

        if(isset($this->unique_id)){
            $vars['unique_id'] = $this->unique_id;
        }

        return $vars;
    }

    public function execute(Context $context)
    {

        $nom = NominationFactory::getByNominatorUniqueId($context['unique_id']);

        CancelQueue::remove($nom);
    }
}
