<?php
namespace nomination\view;

class CommitteeMenu extends \nomination\ViewMenu
{
    public function __construct()
    {
        if(!UserStatus::isCommitteeMember()){
            throw new \nomination\exception\PermissionException('You do have permission to look at this!');
        }
        $this->addViewByName('Nominees', 'NomineeSearch');
        $this->addViewByName('Nominators', 'NominatorSearch');
    }

    public function getRequestVars()
    {
        return array('view' => 'CommitteeMenu');
    }

    public function display(\nomination\Context $context)
    {
        return parent::display($context);
    }
}
