<?php
namespace nomination\command;

/*
 * CancelNomination
 *
 *   Puts the nomination into the 'pending_removal' queue.
 *
 * @author Daniel West <dwest at tux dot appstate dot edu>
 * @package nomination
 */

PHPWS_Core::initModClass('nomination', 'Command.php');
PHPWS_Core::initModClass('nomination', 'CancelQueue.php');

class CancelNomination extends Command {
    public $unique_id;

    public function getRequestVars()
    {
        $vars = array('action'=>'CancelNomination', 'after' => 'RemovalRequest');

        if(isset($this->unique_id)){
            $vars['unique_id'] = $this->unique_id;
        }

        return $vars;
    }

    public function execute(Context $context)
    {
        $nom = NominationFactory::getByNominatorUniqueId($context['unique_id']);

        if(!isset($nom))
        {
          throw new NominationException('The given nomination is null, id = ' . $context['unique_id']);
        }

        CancelQueue::add($nom);
    }
}
