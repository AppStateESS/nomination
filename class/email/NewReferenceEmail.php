<?php
namespace nomination\email;

use nomination\Nomination;
use nomination\Reference;
use nomination\NominationSettings;
use nomination\Period;
use nomination\ReferenceFactory;
use nomination\EmailLog;
use nomination\EmailLogFactory;

/**
*
* A class for handling the nomination reference emails on the creation of a new nomination.
*
* @author Chris Detsch
* @package nomination
*/
class NewReferenceEmail extends Email
{
    private $reference;
    private $nomination;
    private $msgType;

    public function __construct(Nomination $nom, Reference $reference, NominationSettings $emailSettings)
    {
        parent::__construct($emailSettings);
        $this->nomination = $nom;
        $this->reference = $reference;
    }


    public function buildMessage()
    {
        $this->tpl['CURRENT_DATE'] = date('F j, Y');
        $this->tpl['REF_EMAIL'] = $this->reference->getEmail();
        $this->tpl['REF_NAME'] = $this->reference->getFullName();
        $this->tpl['REF_PHONE'] = $this->reference->getPhone();
        $this->tpl['REF_DEPARTMENT'] = $this->reference->getDepartment();
        $this->tpl['REF_RELATION'] = $this->reference->getRelationship();
        $this->tpl['NOMINEE_NAME'] = $this->nomination->getFullName();
        $this->tpl['NOMINATOR_NAME'] = $this->nomination->getNominatorFullName();
        $period = Period::getCurrentPeriod();
        $this->tpl['END_DATE'] = $period->getReadableEndDate();
        $this->tpl['REF_EDIT_LINK'] = $this->reference->getEditLink();
        $this->tpl['AWARD_TITLE'] = $this->emailSettings->getAwardTitleForEmail();
        $this->tpl['SIGNATURE'] = $this->emailSettings->getSignatureForEmail();
        $this->tpl['SIG_POSITION'] = $this->emailSettings->getSigPositionEmail();

        $this->subject = 'Reference Request: ' . $this->emailSettings->getAwardTitleForEmail();

        $ref = ReferenceFactory::getReferenceById($this->reference->getId());

        $this->to[] = $ref->getEmail();

        $this->msgType = 'NEWREF';

    }

    public function getTemplateFileName()
    {
        return 'email/reference_new_nomination.tpl';
    }

    public function logNomEmail()
    {
        $bodyContent = $this->buildMessageBody($this->getTemplateFileName());
        $message = $this->buildSwiftMessage($this->to, $this->fromAddress, $this->fromName, $this->subject, $bodyContent, $this->cc, $this->bcc);

        // Used for the email log within the website
        $messageLog = new EmailLog($this->nomination->getId(), $message,
        $this->msgType, $this->subject, $this->reference->getId(), "REF", time());
        EmailLogFactory::save($messageLog);
    }

}
