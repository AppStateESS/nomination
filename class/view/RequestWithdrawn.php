<?php

PHPWS_Core::initModClass('nomination', 'View.php');

class RequestWithdrawn extends \nomination\View
{

    public function getRequestVars()
    {
        return array('view' => 'RemovalRequest');
    }

    public function display(Context $context)
    {
        Layout::addPageTitle('Thank you');
        return "<h3>Removal Request Withdrawn</h3>";
    }
}
