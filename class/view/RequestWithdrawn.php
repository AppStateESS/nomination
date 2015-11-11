<?php
namespace nomination;

use \nomination\Context;

/*
 * RequestWithdrawn
 *
 *   Handles the view after a request to remove a nomination is withdrawn
 *
 * @author Chris Detsch
 * @package nomination
 */
class RequestWithdrawn extends \nomination\View
{

    public function getRequestVars()
    {
        return array('view' => 'RemovalRequest');
    }

    public function display(Context $context)
    {
        \Layout::addPageTitle('Thank you');
        return "<h3>Removal Request Withdrawn</h3>";
    }
}
