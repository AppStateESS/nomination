<?php

PHPWS_Core::initModClass('nomination', 'View.php');

class ThankYouNominator extends OmNomView
{

    public function getRequestVars()
    {
        return array('view' => 'ThankYouNominator');
    }

    public function display(Context $context)
    {
        Layout::addPageTitle('Thank you');
        return "<h3>Your nomination was successfully submitted.</h3>";
    }
}

?>
