<?php
  /**
   * DeleteNomination
   *
   * Delete a nomination that has been placed in cancel_queue.
   * Also, delete the related references, nomination, and all
   * uploaded documents.
   *
   * @author Robert Bost <bostrt at tux dot appstate dot edu>
   * @author Chris Detsch
   */

PHPWS_Core::initModClass('nomination', 'Command.php');

class DeleteNomination extends Command
{

    public $nominationId;

    public function getRequestVars()
    {
        return array('action' => 'DeleteNomination', 'after' => 'CancelQueuePager',
                     'nominationId' => $this->nominationId);
    }

    public function execute(Context $context)
    {

        if(!UserStatus::isAdmin()){
            throw new PermissionException('You are not allowd to do that!');
        }
        // A nomination ID must be set.
        if(!isset($context['nominationId']) || $context['nominationId'] == ''){
            PHPWS_Core::initModClass('nomination', 'exception/ContextException.php');
            throw new ContextException('Nomination ID is required');
        }

        $nomination = NominationFactory::getNominationbyId($context['nominationId']);

        if(!isset($nomination))
        {
          throw new NominationException('The given nomination is null, id = ' . $id);
        }

        // Send an email
        NominatorEmail::removeNomination($nomination);
        ReferenceEmail::removeNomination($nomination);

        //TODO Delete all relevant nomination data

        EmailLogFactory::deleteEmailLogByNomId($nomination->getId());
        ReferenceFactory::deleteRefByNomId($nomination->getId());
        NominationFactory::deleteNomination($nomination->getId());
        // Delete removal request from queue
        CancelQueue::approve($nomination);

        NQ::simple('nomination', NOMINATION_SUCCESS, 'Nomination deleted. Email sent.');
    }
}
