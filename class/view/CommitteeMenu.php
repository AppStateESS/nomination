<?php

PHPWS_Core::initModClass('nomination', 'ViewMenu.php');

class CommitteeMenu extends ViewMenu
{
    public function __construct()
    {
        if(!UserStatus::isCommitteeMember()){
            throw new PermissionException('You do have permission to look at this!');
        }
        $this->addViewByName('Nominees', 'NomineeSearch');        
        $this->addViewByName('Nominators', 'NominatorSearch');
    }

    public function getRequestVars()
    {
        return array('view' => 'CommitteeMenu');
    }

    public function display(Context $context)
    {
        return parent::display($context);
    }
}
?>
