<?php
namespace nomination\view;

use \nomination\Context;
use \nomination\ViewFactory;
use \nomination\CommandFactory;
use \nomination\UserStatus;
use \nomination\NominationEmail;

/**
 * ReviewEmail
 *
 *  Force the admin to review their email before clicking 'accept'.
 *
 * @author Daniel West <dwest at tux dot appstate dot edu>
 * @package nomination
 */
class ReviewEmail extends \nomination\View {
    protected $from;
    protected $list;
    protected $subject;
    protected $message;

    public function getRequestVars()
    {
        $vars = array('view'=>'ReviewEmail');
        if(isset($this->from)){
            $vars['from'] = $this->from;
        }
        if(isset($this->list)){
            $vars['list'] = $this->list;
        }
        if(isset($this->subject)){
            $vars['subject'] = $this->subject;
        }
        if(isset($this->message)){
            $vars['message'] = $this->message;
        }

        return $vars;
    }

    public function display(Context $context)
    {
        if(!UserStatus::isAdmin()){
            throw new \nomination\exception\PermissionException('You are not allowed to see this!');
        }

        if(!isset($_SESSION['review'])){
            $vf = new ViewFactory;
            $view = $vf->get('SendEmail');
            $view->redirect();
        }

        $data = $_SESSION['review'];

        $cf = new CommandFactory;
        $backCmd = $cf->get('EditEmail');
        $backCmd->from    = $data['from'];
        $backCmd->list    = $data['list'];
        $backCmd->subject = $data['subject'];
        $backCmd->message = $data['message'];
        $submitCmd = $cf->get('DoEmail');
        $submitCmd->from    = $data['from'];
        $submitCmd->list    = $data['list'];
        $submitCmd->subject = $data['subject'];
        $submitCmd->message = $data['message'];

        $back = new \PHPWS_Form('back');
        $backCmd->initForm($back);
        $back->addSubmit('Edit');

        $forward = new \PHPWS_Form('forward');
        $submitCmd->initForm($forward);
        $forward->addSubmit('Send');

        $lists = NominationEmail::getLists();
        $_SESSION['review']['list'] = $lists[$_SESSION['review']['list']];
        $data = array_change_key_case($_SESSION['review'], CASE_UPPER);

        $data['MESSAGE'] = preg_replace('/\n/', '<br />', $data['MESSAGE']);
        $data['BACK']    = implode('', $back->getTemplate());
        $data['FORWARD'] = implode('', $forward->getTemplate());
        unset($_SESSION['review']);

        \Layout::addPageTitle('Review Email');

        return \PHPWS_Template::process($data, 'nomination', 'admin/confirm_email.tpl');
    }
}
