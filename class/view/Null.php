<?php

  /**
   * Null
   *
   * This was the first View for Nomination.
   *
   * @author Robert Bost <bostrt at tux dot appstate dot edu>
   */

PHPWS_Core::initModClass('nomination', 'View.php');

class Null extends \nomination\View
{
    public function getRequestVars()
    {
        return array('view'=>'Null');
    }
    public function display(Context $context)
    {
        return ("<h2>Do you know what's going on? <br/>
                         Maybe it's another drill.</h2>");
    }
}
