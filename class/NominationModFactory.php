<?php
namespace nomination;

/**
 * NominationFactory.php
 *
 * @author Robert Bost <bostrt at tux dot appstate dot edu>
 * @package nomination
 */
class NominationModFactory
{
    public static function getNomination()
    {
        if(UserStatus::isAdmin()) {
            return new AdminNomination();
        } else if(UserStatus::isCommitteeMember()) {
            return new CommitteeNomination();
        } else {
            return new GuestNomination();
        }
    }
}
