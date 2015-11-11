<?php
namespace nomination\view;

use \nomination\Context;

class RemovalRequest extends \nomination\View
{

    public function getRequestVars()
    {
        return array('view' => 'RemovalRequest');
    }

    public function display(Context $context)
    {
        \Layout::addPageTitle('Thank you');
        return "<h3>Removal Request Received and Pending</h3>";
    }
}
