<?php
namespace nomination\view;

/**
 * EmailView
 *
 * View a logged email by id.
 *
 * @author Robert Bost <bostrt at tux dot appstate dot edu>
 */

class EmailView extends \nomination\View
{
    public function getRequestVars()
    {
        return array('view' => 'EmailView');
    }

    public function display(\nomination\Context $context)
    {
        // Admins only
        if(!\nomination\UserStatus::isAdmin())
        {
            \PHPWS_Core::initModClass('nomination', 'exception/PermissionException.php');
            throw new \nomination\exception\PermissionException('You are not allowed to see that!');
        }

        // ID must be set
        if(!isset($context['id']))
        {
            \PHPWS_Core::initModClass('nomination', 'exception/ContextException.php');
            throw new \nomination\exception\ContextException('ID required');
        }

        // Get DB and select where id = ...
        $db = new \PHPWS_DB('nomination_email_log');
        $db->addWhere('id', $context['id']);
        $result = $db->select();

        if($result[0]['receiver_type'] === 'REF'){
          $rdb = \nomination\Reference::getDb();

          $rdb->addWhere('id', $result[0]['receiver_id']);

          $rec = $rdb->select();

          $receiver = $rec[0]['email'];

        } else if($result[0]['receiver_type'] === 'NTR') {
          $ndb = \nomination\Nomination::getDb();

          $ndb->addWhere('id', $result[0]['receiver_id']);

          $rec = $ndb->select();

          $receiver = $rec[0]['nominator_email'];

        } else if($result[0]['receiver_type'] === 'NEE') {
          $ndb = \nomination\Nomination::getDb();

          $ndb->addWhere('id', $result[0]['receiver_id']);

          $rec = $ndb->select();

          $receiver = $rec[0]['email'];
        }

        if(\PHPWS_Error::logIfError($result))
        {
            \PHPWS_Core::initModClass('nomination', 'exception/DatabaseException.php');
            throw new \nomination\exception\DatabaseException($result->toString());
        }

        // AJAX support.
        // @see EmailLogView and javascript/email_log
        if(isset($context['ajax']))
        {
            echo '<div class="row"><label>To:&nbsp;</label>';
            echo nl2br($receiver);
            echo '</div>';
            echo '<div class="row"><label>From:&nbsp;</label>';
            echo nl2br(\PHPWS_Settings::get('nomination', 'email_from_address'));
            echo '</div>';
            echo '<div class="row"><label>Subject:&nbsp;</label>';
            echo nl2br($result[0]['subject']);
            echo '</div>';
            echo nl2br($result[0]['message']);
            exit();
        }
        else
        {
            return nl2br($result[0]['message']);
        }
    }
}
