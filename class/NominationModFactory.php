<?php
namespace nomination;

  /**
   * NominationFactory.php
   *
   * @author Robert Bost <bostrt at tux dot appstate dot edu>
   */

class NominationModFactory
{
    private static $nomination;

    public static function getNomination()
    {
        if(isset(NominationModFactory::$nomination)){
            return NominationFactory::$nomination;
        }
        else if(UserStatus::isAdmin()){
            NominationModFactory::$nomination = new AdminNomination();
        }
        else if(UserStatus::isCommitteeMember()){
            NominationModFactory::$nomination = new CommitteeNomination();
        }
        else {
            NominationModFactory::$nomination = new GuestNomination();
        }

        return NominationModFactory::$nomination;
    }
}
