<?php
namespace nomination;

/**
* A class for sending emails based on a premade list
*
*
* @author Chris Detsch
* @package nomination
*/
class EmailByList extends NominationEmail
{

    public function __construct($list, $subject, $message, $msgType)
    {
        $this->list    = $list;
        $this->subject = $subject;
        $this->message = $message;
        $this->messageType = $msgType;
        $this->from    = \PHPWS_Settings::get('nomination', 'email_from_address');
    }

    public function send()
    {
        $list = $this->list;


        foreach ($list as $id)
        {
            if($this->messageType === 'NEWREF' || $this->messageType === 'REFDEL')
            {
                $ref = ReferenceFactory::getReferenceById($id);

                if(!isset($ref))
                {
                    throw new NominationException('The given reference is null, unique id = ' . $id);
                }

                $nomination = NominationFactory::getNominationbyId($ref->getNominationId());

                if(!isset($nomination))
                {
                    throw new NominationException('The given reference is null, unique id = ' . $ref->getNominationId());
                }
                $this->sendTo($ref->getEmail());
                $this->logEmail($nomination, $ref->getEmail(), $id, 'REF');
            }
            else if($this->messageType === 'NEWNOM' || $this->messageType === 'NOMDEL')
            {
                $nomination = NominationFactory::getNominationbyId($id);

                if(!isset($nomination))
                {
                    throw new NominationException('The given reference is null, unique id = ' . $id);
                }

                $this->sendTo($nomination->getNominatorEmail());
                $this->logEmail($nomination, $nomination->getNominatorEmail(), $id, 'NTR');
            }
        }
    }

}
