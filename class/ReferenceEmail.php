<?php
namespace nomination;

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
        $vars['AWARD_TITLE'] = \PHPWS_Settings::get('nomination', 'award_title');
        $vars['SIGNATURE'] = \PHPWS_Settings::get('nomination', 'signature');
        $vars['SIG_POSITION'] = \PHPWS_Settings::get('nomination', 'sig_position');
        $vars['AWARD_DESCRIPTION'] = \PHPWS_Settings::get('nomination', 'award_description');


        $list = array($reference->getId());
        $subject = 'Reference Request: ' . \PHPWS_Settings::get('nomination', 'award_title');
        $msg = \PHPWS_Template::process($vars, 'nomination', 'email/reference_new_nomination.tpl');
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
    public static function uploadDocument(Reference $reference)
    {
        $vars = array();

        $vars['CURRENT_DATE'] = date('F j, Y');
        $vars['NAME'] = $reference->getFullName();
        $nom = NominationFactory::getNominationbyId($reference->getNominationId());
        $vars['NOMINEE_NAME'] = $nom->getFirstName() . ' ' . $nom->getLastName();
        $vars['AWARD_NAME'] = \PHPWS_Settings::get('nomination', 'award_title');
        $period = Period::getCurrentPeriod();
        $vars['END_DATE'] = $period->getReadableEndDate();
        $vars['EDIT_LINK'] = $reference->getEditLink();

        $list = array($reference);
        $subject = \PHPWS_Settings::get('nomination', 'award_title');
        $msg = \PHPWS_Template::process($vars, 'nomination', 'email/reference_letter_submit.tpl');
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
    public static function updateNomination(Reference $reference, Nomination $nomination)
    {
        $vars = array();

        $vars['CURRENT_DATE'] = date('F j, Y');
        $vars['REF_EMAIL'] = $reference->getEmail();
        $vars['REF_NAME'] = $reference->getFullName();
        $vars['REF_PHONE'] = $reference->getPhone();
        $vars['REF_DEPARTMENT'] = $reference->getDepartment();
        $vars['REF_RELATION'] = $reference->getRelationship();
        $vars['NOMINEE_NAME'] = $nomination->getFirstName() . ' ' . $nomination->getLastName();
        $vars['NOMINATOR_NAME'] = $nomination->getNominatorFirstName() . ' ' . $nomination->getNominatorLastName();
        $period = Period::getCurrentPeriod();
        $vars['END_DATE'] = $period->getReadableEndDate();
        $vars['REF_EDIT_LINK'] = $reference->getEditLink();
        $vars['AWARD_TITLE'] = \PHPWS_Settings::get('nomination', 'award_title');
        $vars['SIGNATURE'] = \PHPWS_Settings::get('nomination', 'signature');
        $vars['SIG_POSITION'] = \PHPWS_Settings::get('nomination', 'sig_position');

        $list = array($reference->getId());
        $subject = 'Reference Request: ' . \PHPWS_Settings::get('nomination', 'award_title');
        $msg = \PHPWS_Template::process($vars, 'nomination', 'email/reference_new_nomination.tpl');
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
        $vars['AWARD_NAME'] = \PHPWS_Settings::get('nomination', 'award_title');

        $references = ReferenceFactory::getByNominationId($nomination->getId());

        $list = array();
        foreach ($references as $ref) {
            array_push($list, $ref->getId());
        }
        $subject = 'Nomination Removal Request Approved';
        $msg = \PHPWS_Template::process($vars, 'nomination', 'email/removal_request_approved.tpl');
        $msgType = 'REFDEL';

        $email = new EmailByList($list, $subject, $msg, $msgType);

        $email->send();

    }

}
