<?php

  /**
   * EmailLogView
   *
   * View email log entries
   *
   * @author Robert Bost <bostrt at tux dot appstate dot edu>
   */

PHPWS_Core::initModClass('nomination', 'View.php');

class EmailLogView extends \nomination\View
{

    public function getRequestVars()
    {
        return array('view'=>'EmailLogView');
    }

    public function display(Context $context)
    {
        if(!UserStatus::isAdmin()){
            PHPWS_Core::initModClass('nomination', 'exception/PermissionException.php');
            throw new PermissionException('You are not allowed to see that!');
        }

        PHPWS_Core::initModClass('nomination', 'EmailMessage.php');

        $pager = new DBPager(nomination_email_log, 'EmailMessage');

        $pager->setModule('nomination');
        $pager->setTemplate('admin/email_log_view.tpl');
        $pager->setEmptyMessage('Email log is empty');
        $pager->joinResult('nominee_id', 'nomination_nomination', 'id',
                           'last_name', 'nominee_last_name');

        $pager->addSortHeader('nominee_last_name', 'Nominee');
        $pager->addSortHeader('sent_on', 'Sent on');
        $pager->addSortHeader('message_type', 'Message Type');
        $pager->addSortHeader('receiver_type', 'To Type');

        // DBPager mess
        if(isset($context['orderby'])){
            if(isset($context['orderby_dir'])){
                $pager->setOrder($context['orderby'], $context['orderby_dir']);
            } else {
                $pager->setOrder($context['orderby'], 'desc');
            }
        } else {
            $pager->setOrder('sent_on', 'desc');
        }
        $pager->addRowTags('rowTags');

        javascript('jquery');
        javascript('jquery_ui');
        javascriptMod('nomination', 'email_view');

        Layout::addPageTitle('Email Log');

        return $pager->get();
    }
}

?>
