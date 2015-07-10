<?php

/**
  *
  * A class for handling the nomination reference emails on the creation of a new nomination.
  *
  * @author Chris Detsch
  * @package nomination
  */
  class ReferenceEmail
  {

    /**
     * Sends an email to a reference listed on a new nomination
     *
     * @param $reference Reference
     * @param $nom Nomination
     */
    public static function newNomination(Reference $reference, Nomination $nom)
    {
        $vars = array();

        $vars['CURRENT_DATE'] = date('F j, Y');
        $vars['REF_EMAIL'] = $reference->getEmail();
        $vars['REF_NAME'] = $reference->getFullName();
        $vars['REF_PHONE'] = $reference->getPhone();
        $vars['REF_DEPARTMENT'] = $reference->getDepartment();
        $vars['REF_RELATION'] = $reference->getRelationship();
        $vars['NOMINEE_NAME'] = $nom->getFullName();
        $vars['NOMINATOR_NAME'] = $nom->getNominatorFullName();
        $period = Period::getCurrentPeriod();
        $vars['END_DATE'] = $period->getReadableEndDate();
        $vars['REF_EDIT_LINK'] = $reference->getEditLink();
        $vars['AWARD_TITLE'] = PHPWS_Settings::get('nomination', 'award_title');


        $list = array($reference->getId());
        $subject = 'Reference Request: ' . PHPWS_Settings::get('nomination', 'award_title');
        $msg = PHPWS_Template::process($vars, 'nomination', 'email/reference_new_nomination.tpl');
        $msgType = 'NEWREF';


        $email = new EmailByList($list, $subject, $msg, $msgType);
        $email->send();
    }

    /**
     * Sends an email to a reference listed on a new nomination
     *
     * @param $reference Reference
     * @param $nominee Nominee
     */
    public static function uploadDocument(Reference $reference, Nominee $nominee)
    {
        $vars = array();

        $vars['CURRENT_DATE'] = date('F j, Y');
        $vars['NAME'] = $reference->getFullName();
        $vars['NOMINEE_NAME'] = $nominee->getFullName();
        $vars['AWARD_NAME'] = PHPWS_Settings::get('nomination', 'award_title');
        $period = Period::getCurrentPeriod();
        $vars['END_DATE'] = $period->getReadableEndDate();
        $vars['EDIT_LINK'] = $reference->getEditLink();

        $list = array($reference);
        $subject = PHPWS_Settings::get('nomination', 'award_title');
        $msg = PHPWS_Template::process($vars, 'nomination', 'email/reference_letter_submit.tpl');
        $msgType = 'REFUPL';

        $email = new EmailByList($list, $subject, $msg, $msgType);
        $email->send();
    }

    /**
     * Sends an email to a reference listed on a new nomination
     *
     * @param $reference Reference
     * @param $nominee Nominee
     * @param $nominator Nominator
     */
    public static function updateNomination(Reference $reference, Nominator $nominator, Nominee $nominee)
    {
        $vars = array();

        $vars['CURRENT_DATE'] = date('F j, Y');
        $vars['REF_EMAIL'] = $reference->getEmail();
        $vars['REF_NAME'] = $reference->getFullName();
        $vars['REF_PHONE'] = $reference->getPhone();
        $vars['REF_DEPARTMENT'] = $reference->getDepartment();
        $vars['REF_RELATION'] = $reference->getRelationship();
        $vars['NOMINEE_NAME'] = $nominee->getFullName();
        $vars['NOMINATOR_NAME'] = $nominator->getFullName();
        $period = Period::getCurrentPeriod();
        $vars['END_DATE'] = $period->getReadableEndDate();
        $vars['REF_EDIT_LINK'] = $reference->getEditLink();

        $list = array($reference);
        $subject = PHPWS_Settings::get('nomination', 'award_title');
        $msg = PHPWS_Template::process($vars, 'nomination', 'email/reference_new_nomination.tpl');
        $msgType = 'UPDNOM';

        $email = new EmailByList($list, $subject, $msg, $msgType);
        $email->send();
    }

    /**
     * Sends a message to the nominator of nomination that has been removed
     *
     * @param $nominator Nominator
     * @param $nominee Nominee
     */
    public static function removeNomination(Nomination $nomination)
    {
        $vars = array();

        $vars['NAME'] = $nomination->getNominatorFirstName() . ' ' . $nomination->getNominatorLastName();
        $vars['NOMINEE_NAME'] = $nomination->getFirstName() . ' ' . $nomination->getLastName();
        $vars['AWARD_NAME'] = PHPWS_Settings::get('nomination', 'award_title');

        $list = array($nomination->getId());
        $subject = 'Nomination Removal Request Approved';
        $msg = PHPWS_Template::process($vars, 'nomination', 'email/removal_request_approved.tpl');
        $msgType = 'NOMDEL';

        $email = new EmailByList($list, $subject, $msg, $msgType);
        $email->send();
    }

  }
