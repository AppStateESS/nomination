<?php

/**
  *
  * A class for handling the nomination references on the creation of a new nomination.
  *
  * @author Chris Detsch
  * @package nomination
  */
  class NominatorEmail
  {

    /**
     * Sends a message to the nominator of a new nomination
     *
     * @param $nom Nomination
     */
    public static function newNomination(Nomination $nom)
    {
        $vars = array();

        $vars['CURRENT_DATE'] = date('F j, Y');
        $vars['NOMINATOR_NAME'] = $nom->getNominatorFullName(); // NB: This could be an empty string for self-nominations
        $vars['NOMINEE_NAME'] = $nom->getFullName();
        $vars['AWARD_NAME'] = PHPWS_Settings::get('nomination', 'award_title');
        $period = Period::getCurrentPeriod();
        $vars['END_DATE'] = $period->getReadableEndDate();
        $vars['EDIT_LINK'] = $nom->getEditLink(); //TODO nominator editing

        $vars['SIGNATURE'] = PHPWS_Settings::get('nomination', 'signature');
        $vars['SIG_POSITION'] = PHPWS_Settings::get('nomination', 'sig_position');

        $list = array($nom->getId());
        $subject = $vars['AWARD_NAME'];
        $msg = PHPWS_Template::process($vars, 'nomination', 'email/nominator_new_nomination.tpl');
        $msgType = 'NEWNOM';

        $email = new EmailByList($list, $subject, $msg, $msgType);
        $email->send();
    }

    /**
     * Sends a message to the nominator of nomination that has been removed
     *
     * @param $nominator Nominator
     * @param $nominee Nominee
     */
    public static function removeNomination(Nominator $nominator, Nominee $nominee)
    {
        $vars = array();

        $vars['NAME'] = $nominator->getFullname();
        $vars['NOMINEE_NAME'] = $nominee->getFullName();
        $vars['AWARD_NAME'] = PHPWS_Settings::get('nomination', 'award_title');

        $list = array($nominator);
        $subject = 'Nomination Removal Request Approved';
        $msg = PHPWS_Template::process($vars, 'nomination', 'email/removal_request_approved.tpl');
        $msgType = 'NOMDEL';

        $email = new EmailByList($list, $subject, $msg, $msgType);
        $email->send();
    }


    /**
     * Sends a message to the nominator of a nomination that has been updated.
     *
     * @param $nominator Nominator
     * @param $nominee Nominee
     */
    public static function updateNomination(Nominator $nominator, Nominee $nominee)
    {
        $vars = array();

        $vars['NAME'] = $nominator->getFullName();
        $vars['AWARD_NAME'] = PHPWS_Settings::get('nomination', 'award_title');
        $vars['NOMINEE_NAME'] = $nominee->getFullName();
        $period = Period::getCurrentPeriod();
        $vars['END_DATE'] = $period->getReadableEndDate();
        $vars['EDIT_LINK'] = $nominator->getEditLink();

        $list = array($nominator);
        $subject = $vars['AWARD_NAME']. ' | Updated';
        $msg = PHPWS_Template::process($vars, 'nomination', 'email/nominator_update_nomination.tpl');
        $msgType = 'UPDNOM';

        $email = new EmailByList($list, $subject, $msg, $msgType);
        $email->send();
    }

  }
