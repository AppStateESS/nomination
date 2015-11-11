<?php
namespace nomination\view;

  /**
   * NominationMainMenu
   *
   * This interfaces with Nomination's ViewFactory
   *
   * @author Robert Bost <bostrt at tux dot appstate dot edu>
   */

class NominationMainMenu extends \nomination\othermenu\MainMenu
{
    public function addMenuItemByName($name, $text, $tag=null, $parentTag=null)
    {
        $vFactory = new \nomination\ViewFactory();
        $view = $vFactory->get($name);

        $this->addMenuItem($view->getLink($text), $tag, $parentTag);
    }
}
