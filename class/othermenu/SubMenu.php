<?php

PHPWS_Core::initModClass('nomination', 'othermenu/MenuItem.php');

class SubMenu extends MenuItem implements arrayaccess
{
  protected $container = array();

  /**
   * Insert new menu item at index $tag
   */
  public function addMenuItem($text, $tag=null, $parentTag=null)
  {
    // find the menu they want to add an item to
    $menu = $this->getMenuByTag($parentTag);

    // If tag isn't given then make one for them
    if(is_null($tag)){
      $tag = $menu->getTag() . '-item-' . $menu->getMenuItemCount();
    }

    // Create the item
    $item = new MenuItem($text, $tag);

    $menu[$tag] = $item;
  }

  /**
   * Insert new sub menu at index $tag
   */
  public function addSubMenu($text, $tag=null, $parentTag=null)
  {
    // find the menu they want to add another menu to
    $menu = $this->getMenuByTag($parentTag);

    // If tag isn't given then make one for them
    if(is_null($tag)){
      $tag = $menu->getTag() . '-submenu-' . $menu->getSubMenuCount();
    }
    // Create sub menu
    $subMenu = new SubMenu($text, $tag);

    // Add the menu
    $menu[$tag] = $subMenu;
  }

  public function getMenuByTag($tag)
  {
    // Base case: $this or null
    if($this->tag == $tag || is_null($tag)){
      if($this instanceof SubMenu){
	return $this;
      } else {
	// If tag matches and $this isn't a SubMenu
	throw new Exception('Tag is used by MenuItem.');
      }
    }
    // Check container for sub menu
    else {
      foreach($this->container as $item){
	if($item instanceof SubMenu){
	  $result = $item->getMenuByTag($tag);
	  if(!is_null($result)){
	    return $result;
	  }
	}
      }
    }
    // otherwise return null!
    return null;
  }

  /**
   * return the number of MenuItems in container
   */
  public function getMenuItemCount()
  {
    $count = 0;
    foreach($this->container as $item){
      if(get_class($item) == 'MenuItem'){
	$count++;
      }
    }
    return $count;
  }

  /**
   * return the number of SubMenus in container
   */
  public function getSubMenuCount()
  {
    $count = 0;
    foreach($this->container as $item){
      if(get_class($item) == 'SubMenu'){
	$count++;
      }
    }
    return $count;
  }

  /**
   * Loop over items in this menu,
   * showing each one.
   */
  public function show()
  {
    $tpl = array();

    $tpl['MENU_TAG'] = $this->tag;
    $tpl['MENU_TEXT'] = $this->text;

    foreach($this->container as $item){
      $tpl['menu_items'][] = array('CONTENT' => $item->show());
    }

    return PHPWS_Template::process($tpl, 'nomination', 'othermenu/submenu.tpl');
  }

  public function toString()
  {
    echo '<pre>';
    print_r($this->show());
    echo '</pre>';
  }

  /**
   * Inherited from arrayaccess
   */
  public function offsetSet($offset, $value) {
    $this->container[$offset] = $value;
  }
  public function offsetExists($offset) {
    return isset($this->container[$offset]);
  }
  public function offsetUnset($offset) {
    unset($this->container[$offset]);
  }
  public function offsetGet($offset) {
    return isset($this->container[$offset]) ? $this->container[$offset] : null;
  }
}
