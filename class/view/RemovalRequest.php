<?php

PHPWS_Core::initModClass('nomination', 'View.php');

class RemovalRequest extends \nomination\View
{

    public function getRequestVars()
    {
        return array('view' => 'RemovalRequest');
    }

    public function display(Context $context)
    {
        Layout::addPageTitle('Thank you');
        return "<h3>Removal Request Received and Pending</h3>";
    }
}
