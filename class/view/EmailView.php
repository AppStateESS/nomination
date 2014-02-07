<?php

PHPWS_Core::initModClass("nomination", "View.php");

/**
 * EmailView
 *
 * View a logged email by id.
 *
 * @author Robert Bost <bostrt at tux dot appstate dot edu>
 */

class EmailView extends OmNomView
{
    public function getRequestVars()
    {
        return array('view' => 'EmailView');
    }

    public function display(Context $context)
    {
        // Admins only
        if(!UserStatus::isAdmin()){
            PHPWS_Core::initModClass('nomination', 'exception/PermissionException.php');
            throw new PermissionException('You are not allowed to see that!');
        }

        // ID must be set
        if(!isset($context['id'])){
            PHPWS_Core::initModClass('nomination', 'exception/ContextException.php');
            throw new ContextException('ID required');
        }

        PHPWS_Core::initModClass('nomination', 'EmailMessage.php');

        // Get DB and select where id = ...
        $db = EmailMessage::getDb();

        $db->addWhere('id', $context['id']);
        $db->addColumn('message');

        $result = $db->select();

        if(PHPWS_Error::logIfError($result)){
            PHPWS_Core::initModClass('nomination', 'exception/DatabaseException.php');
            throw new DatabaseException($result->toString());
        }

        // AJAX support. 
        // @see EmailLogView and javascript/email_log
        if(isset($context['ajax'])){
            echo nl2br($result[0]['message']);
            exit();
        }else{
            return nl2br($result[0]['message']);
        }
    }
}

?>
