<?php
namespace nomination\view;

use \nomination\Context;

class ThankYouNominator extends \nomination\View
{

    public function getRequestVars()
    {
        return array('view' => 'ThankYouNominator');
    }

    public function display(Context $context)
    {
        \Layout::addPageTitle('Thank you');
        return "<h3>Nomination Form Successfully Submitted</h3>";
    }
}
