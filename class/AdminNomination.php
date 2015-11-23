<?php
namespace nomination;

class AdminNomination extends NominationMod
{
    protected $defaultView = 'AdminMainMenu';

    public function process()
    {
        parent::process();

        $userView = new view\UserView();
        $userView->setMain($this->content);

        $sideMenu = new view\AdminMenu();
        $userView->addSideMenu($sideMenu->display($this->context));

        \Layout::add($userView->display($this->context));
    }
}
