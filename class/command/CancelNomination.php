<?php
namespace nomination\command;

use \nomination\Command;
use \nomination\Context;

/*
 * CancelNomination
 *
 *   Puts the nomination into the 'pending_removal' queue.
 *
 * @author Daniel West <dwest at tux dot appstate dot edu>
 * @package nomination
 */

\PHPWS_Core::initModClass('nomination', 'Command.php');
\PHPWS_Core::initModClass('nomination', 'CancelQueue.php');

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
        $nom = \nomination\NominationFactory::getByNominatorUniqueId($context['unique_id']);

        if(!isset($nom))
        {
          throw new \nomination\Exception\NominationException('The given nomination is null, id = ' . $context['unique_id']);
        }

        \nomination\CancelQueue::add($nom);
    }
}
