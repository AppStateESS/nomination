<?php
/*
 * CancelQueuePager
 *
 *   Provides admins with a pager to manage requests to cancel a nomination.
 *
 * @author Daniel West <dwest at tux dot appstate dot edu>
 * @package nomination
 */

PHPWS_Core::initModClass('nomination', 'View.php');
PHPWS_Core::initModClass('nomination', 'CancelQueue.php');
PHPWS_Core::initCoreClass('DBPager.php');

class CancelQueuePager extends \nomination\View {

    public function getRequestVars()
    {
        return array('view'=>'CancelQueuePager');
    }

    public function display(Context $form)
    {
        if(!UserStatus::isAdmin()){
            throw new PermissionException('You are not allowed to see that!');
        }
        $pager = new DBPager('nomination_cancel_queue', 'CancelQueue');
        $pager->setModule('nomination');
        $pager->setTemplate('admin/approve_remove.tpl');
        $pager->setEmptyMessage('No nominators are requesting nomination removal at this time.');

        javascript('jquery');

        $pager->addRowTags('rowTags');

        return $pager->get();
    }
}
