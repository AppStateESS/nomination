<?php

/**
 * SendEmail
 *
 *   Admin interface for sending email messages to different groups of individuals of interest in Nomination.
 *
 * @author Daniel West <dwest at tux dot appstate dot edu>
 * @package nomination
 */

PHPWS_Core::initModClass('nomination', 'View.php');
PHPWS_Core::initModClass('nomination', 'Context.php');
PHPWS_Core::initModClass('nomination', 'NominationEmail.php');
PHPWS_Core::initModClass('nomination', 'CommandFactory.php');

class SendEmail extends \nomination\View {

    public function getRequestVars()
    {
        $vars = array('view'=>'SendEmail');

        return $vars;
    }

    public function display(Context $context)
    {
        if(!UserStatus::isAdmin()){
            throw new PermissionException('You are not allowed to see this!');
        }

        $cf = new CommandFactory;
        $cmd = $cf->get('SubmitReviewEmail');

        $form = new PHPWS_Form('email');
        $cmd->initForm($form);

        $form->addDropBox('list', NominationEmail::getLists());
        $form->setLabel('list', 'Recipients');
        $form->addCssClass('list', 'form-control');

        $form->addText('subject');
        $form->setLabel('subject', 'Subject');
        $form->addCssClass('subject', 'form-control');

        $form->addTextArea('message');
        $form->setLabel('message', 'Message');
        $form->addCssClass('message', 'form-control');

        $form->addSubmit('Submit');

        if(isset($_SESSION['review'])){
            $form->plugIn($_SESSION['review']);
            unset($_SESSION['review']);
        }

        Layout::addPageTitle('Send Email');

        return PHPWS_Template::process($form->getTemplate(), 'nomination', 'admin/email_form.tpl');
    }
}
?>
