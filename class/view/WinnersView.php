<?php
namespace nomination\view;
use \nomination\Context;
use \nomination\UserStatus;

  /**
   * WinnersView
   *
   * Administrative View for looking at winners for
   * current and past nomination periods.
   *
   * @author Robert Bost <bostrt at tux dot appstate dot edu>
   * @package nomination
   */
class WinnersView extends \nomination\View
{
    public function getRequestVars()
    {
        return array('view' => 'WinnersView');
    }

    public function display(Context $context)
    {
        if(!UserStatus::isAdmin()){
            throw new \nomination\exception\PermissionException('You are not allowed to see this!');
        }

        $pager = new \DBPager('nomination_nomination', '\nomination\DBNomination');
        $pager->setModule('nomination');
        $pager->setTemplate('admin/winners.tpl');
        $pager->setEmptyMessage('No Winners Yet');

        // conditions
        $pager->addWhere('winner', 0, '!=');
        //TODO: This'll work for testing. May need those joins still.

        // sort headers
        $pager->addSortHeader('period', 'Period');
        $pager->addSortHeader('last_name', 'Nominee');
        $pager->addSortHeader('nominator_last_name', 'Nominator');

        // Row tags
        $pager->addRowTags('rowTags');

        \Layout::addPageTitle('View Winners');

        return $pager->get();
    }

}
