<?php
namespace nomination\view;

  /**
   * If this page is displayed then the user probably typed
   * something in wrong.
   *
   * @author Robert Bost <bostrt at tux dot appstate dot edu>
   */

class FourOhFour extends \nomination\View
{
    public function getRequestVars()
    {
        return array('view' => 'FourOhFour');
    }

    public function display(\nomination\Context $context)
    {
        return 'Your request could not be processed. <br />
 Please <a href="mailto:bostrt@tux.appstate.edu">contact</a> us.';
    }
}
