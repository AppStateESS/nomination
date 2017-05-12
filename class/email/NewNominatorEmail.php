<?php
namespace nomination\email;

use nomination\Nomination;
use nomination\NominationSettings;
use nomination\Period;
use nomination\EmailLog;
use nomination\EmailLogFactory;

/**
  *
  * A class for handling the nomination references on the creation of a new nomination.
  *
  * @author Chris Detsch
  * @package nomination
  */
  class NewNominatorEmail extends Email
  {
    private $nomination;
    private $msgType;

    public function __construct(Nomination $nom, NominationSettings $emailSettings)
    {
        parent::__construct($emailSettings);
        $this->nomination = $nom;
    }


    public function buildMessage()
    {
        $this->tpl['CURRENT_DATE'] = date('F j, Y');
        $this->tpl['NOMINATOR_NAME'] = $this->nomination->getNominatorFullName(); // NB: This could be an empty string for self-nominations
        $this->tpl['NOMINEE_NAME'] = $this->nomination->getFullName();
        $period = Period::getCurrentPeriod();
        $this->tpl['END_DATE'] = $period->getReadableEndDate();
        $this->tpl['EDIT_LINK'] = $this->nomination->getEditLink(); //TODO nominator editing
        $this->tpl['SIGNATURE'] = $this->emailSettings->getSignatureForEmail();
        $this->tpl['SIG_POSITION'] = $this->emailSettings->getSigPositionEmail();

        $this->subject = $this->emailSettings->getAwardTitleForEmail();
        $this->to[] = $this->nomination->getNominatorEmail();

        $this->msgType = 'NEWNOM';

    }

    public function getTemplateFileName()
    {
        //$msg = \PHPWS_Template::process($this->tpl, 'nomination', 'email/nominator_new_nomination.tpl');
        return 'email/nominator_new_nomination.tpl';
    }

    public function logNomEmail($id = null)
    {
        $bodyContent = $this->buildMessageBody($this->getTemplateFileName());
        $message = $this->buildSwiftMessage($this->to, $this->fromAddress, $this->fromName, $this->subject, $bodyContent, $this->cc, $this->bcc);

        // Used for the email log within the website
        $messageLog = new EmailLog($this->nomination->getId(), $message->getBody(),
        $this->msgType, $this->subject, $this->nomination->getId(), "NTR", time());
        EmailLogFactory::save($messageLog);
    }

  }
