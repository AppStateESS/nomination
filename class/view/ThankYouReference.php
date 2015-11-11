<?php
namespace nomination\view;

use \nomination\Context;

  /**
   * ThankYouReference
   *
   * Tell the reference 'thanks' for uploading their letter
   *
   * @author Robert Bost <bostrt at tux dot appstate dot edu>
   */

class ThankYouReference extends \nomination\View
{

    public function getRequestVars()
    {
        return array('view' => 'ThankYouReference');
    }

    public function display(Context $context)
    {
        \Layout::addPageTitle('Thank you');
        return "<h3>Your letter of recommendation was successfully submitted.</h3>";
    }
}
