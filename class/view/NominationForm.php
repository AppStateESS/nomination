<?php
namespace nomination\view;

use \nomination\Context;
use \nomination\CommandFactory;
use \nomination\Period;
use \nomination\NominationFactory;
use \nomination\CancelQueue;
use \nomination\NominationFieldVisibility;
use \nomination\UserStatus;
use \nomination\Reference;
use \nomination\Nomination;
use \nomination\NominationDocument;
use \nomination\FallthroughContext;

\PHPWS_Core::initCoreClass('Captcha.php');
\PHPWS_Core::initCoreClass('Form.php');

/**
* NominationForm - View class to handle creating the nomination form fields
*
* @author Robert Bost?
* @author Jeremy Booker
* @package nomination
*/
class NominationForm extends \nomination\View
{

    public function getRequestVars()
    {
        $vars = array('view' => 'NominationForm');

        if(isset($this->unique_id)){
            $vars['unique_id'] = $this->unique_id;
        }

        return $vars;
    }

    public function display(Context $context)
    {
        $tpl = array();
        $cmdFactory = new CommandFactory();

        // Check if nomination period has ended or hasn't started yet

        $currPeriod = Period::getCurrentPeriod();

        if($currPeriod === null) {
            return '<h2>There is no nomination time period configured. Please contact the site administrators.</h2>';
        }
        $currPeriod = Period::getCurrentPeriod();

        if(Period::isOver()) {
            $end = $currPeriod->getReadableEndDate();
            return '<h2>The nomination ended on '.$end.'.</h2>';
        } else if(!Period::hasBegun()) {
            $begin = $currPeriod->getReadableStartDate();
            return '<h2>The nomination period will begin on '.$begin.'.</h2>';
        }

        $c = new FallthroughContext(array());
        $c->addFallthrough($context);

        /**
        * These forms are displayed if the Nominator is editing the nomination
        */
        if(isset($context['unique_id'])) {
            //setup the fallthrough context
            $nomination = NominationFactory::getByNominatorUniqueId($context['unique_id']);

            if(!isset($nomination)) {
                throw new \nomination\exception\NominationException('The given nomination is null, unique_id = ' . $context['unique_id']);
            }

            $c->restoreNominationForm($nomination);

            $edit = true;

            //...and add a button for the nominator to cancel their nomination
            // or remove the request to delete their nomination
            $cancelForm = new \PHPWS_Form('cancel_nominationForm');

            // CancelQueue contains method
            if(CancelQueue::contains($nomination->getId())) {
                $cmd = $cmdFactory->get('WithdrawCancelNomination');
                $cancelForm->addSubmit('Remove Request');
                $cmd->unique_id = $context['unique_id'];

                $cmd->initForm($cancelForm);

                $tpl['withdraw']['WITHDRAW_BUTTON'] = $cancelForm->getTemplate();
            } else {
                $cmd = $cmdFactory->get('CancelNomination');
                $cancelForm->addSubmit('Submit Request');
                $cmd->unique_id = $context['unique_id'];

                $cmd->initForm($cancelForm);

                $tpl['cancel']['CANCEL_BUTTON'] = $cancelForm->getTemplate();
            }

        } else {
            $edit = false;
        }


        $form = new \PHPWS_Form('nomination_form');

        // Decide which submission command to use
        if(!isset($c['unique_id'])){
            $submitCmd = $cmdFactory->get('CreateNomination');
        } else {
            $submitCmd = $cmdFactory->get('EditNomination');
            $submitCmd->unique_id = $c['unique_id'];
        }

        $submitCmd->initForm($form);



        $tpl['AWARD_TITLE'] = \PHPWS_Settings::get('nomination', 'award_title');
        $currPeriod = Period::getCurrentPeriod();
        $tpl['PERIOD_END'] = $currPeriod->getReadableEndDate();
        $tpl['NUM_REFS'] = \PHPWS_Settings::get('nomination', 'num_references_req');


        $vis = new NominationFieldVisibility();


        if(isset($context['unique_id'])) {
            $form->addHidden('nominator_unique_id', $context['unique_id']);

        }


        /****************
        * Nominee Info *
        ****************/
        //TODO: Make some of these configuable so we can show/hide them from settings
        $form->addText('nominee_first_name',
        isset($c['nominee_first_name']) ? $c['nominee_first_name'] : '');
        $form->addCssClass('nominee_first_name', 'form-control');
        $form->setLabel('nominee_first_name', 'First name');

        $form->addText('nominee_middle_name',
        isset($c['nominee_middle_name']) ? $c['nominee_middle_name'] : '');
        $form->addCssClass('nominee_middle_name', 'form-control');
        $form->setLabel('nominee_middle_name', 'Middle name');

        $form->addText('nominee_last_name',
        isset($c['nominee_last_name']) ? $c['nominee_last_name'] : '');
        $form->addCssClass('nominee_last_name', 'form-control');
        $form->setLabel('nominee_last_name', 'Last name');

        if($edit && !UserStatus::isAdmin()) {
            $tpl['NOMINEE_EMAIL'] = '<label>' . $c['nominee_email'] . '</label>';
        } else {
            $form->addText('nominee_email',
            isset($c['nominee_email']) ? $c['nominee_email'] : '');
            $form->addCssClass('nominee_email', 'form-control');
            $tpl['NOMINEE_ADD_ON'] = '<div class="input-group-addon">@appstate.edu</div>';
        }


        if($vis->isVisible('nominee_asubox')) {
            $form->addText('nominee_asubox',
            isset($c['nominee_asubox']) ? $c['nominee_asubox'] : '');
            $form->addCssClass('nominee_asubox', 'form-control');
            $form->setLabel('nominee_asubox', 'ASU Box');
        }

        if($vis->isVisible('nominee_position')) {
            $form->addText('nominee_position',
            isset($c['nominee_position']) ? $c['nominee_position'] : '');
            $form->addCssClass('nominee_position', 'form-control');
            $form->setLabel('nominee_position', 'Position on Campus');
        }

        if($vis->isVisible('nominee_department_major')) {
            $form->addText('nominee_department_major',
            isset($c['nominee_major']) ? $c['nominee_major'] : '');
            $form->addCssClass('nominee_department_major', 'form-control');
            $form->setLabel('nominee_department_major', 'Department/Major');
        }

        if($vis->isVisible('nominee_years')) {
            $form->addText('nominee_years',
            isset($c['nominee_years']) ? $c['nominee_years'] : '');
            $form->addCssClass('nominee_years', 'form-control');
            $form->setLabel('nominee_years', 'Years at Appalachian');
        }

        if($vis->isVisible('nominee_responsibility')) {
            $form->addRadioAssoc('nominee_responsibility', array(1=>'Yes',2=>'No'));

            if(isset($c['nominee_responsibility']))
            $form->setMatch('nominee_responsibility', $c['nominee_responsibility']);
        }

        if($vis->isVisible('nominee_banner_id')) {
            if($edit && !UserStatus::isAdmin())
            {
                $tpl['NOMINEE_BANNER_ID'] = '<label> ' . $c['nominee_banner_id'] . '</label>';
            } else {
                $form->addText('nominee_banner_id',
                isset($c['nominee_banner_id']) ? $c['nominee_banner_id'] : '');
                $form->addCssClass('nominee_banner_id', 'form-control');
            }
        }
        if($vis->isVisible('nominee_phone')) {
            $form->addText('nominee_phone',
            isset($c['nominee_phone']) ? $c['nominee_phone'] : '');
            $form->addCssClass('nominee_phone', 'form-control');
            $form->setLabel('nominee_phone', 'Phone Number');
        }
        if($vis->isVisible('nominee_gpa')) {
            $form->addText('nominee_gpa',
            isset($c['nominee_gpa']) ? $c['nominee_gpa'] : '');
            $form->addCssClass('nominee_gpa', 'form-control');
            $form->setLabel('nominee_gpa', 'GPA');
        }
        if($vis->isVisible('nominee_class')) {
            $form->addDropBox('nominee_class', array(-1=>'Select', 'fr'=>'Freshmen', 'so'=>'Sophomore', 'jr'=>'Junior', 'sr'=>'Senior', 'grad'=>'Graduate'));
            $form->setMatch('nominee_class', isset($c['nominee_class']) ? $c['nominee_class'] : -1);
            $form->setLabel('nominee_class', 'Class');
            $form->addCssClass('nominee_class', 'form-control');

        }


        /************
        * Category *
        ************/
        if($vis->isVisible('category')) {
            $category_radio = array(NOMINATION_STUDENT_LEADER, NOMINATION_STUDENT_EDUCATOR, NOMINATION_FACULTY_MEMBER, NOMINATION_EMPLOYEE);
            $form->addRadio('category', $category_radio);
            $form->setMatch('category', isset($c['category']) ? $c['category'] : -1);
        }

        /*************
        * References *
        *************/
        //TODO: fix reference editing

        /**
        * NB: Field names are sensitive and done this way on purpose
        * so that multiple fields with the same name can be submitted.
        */
        $numRefsReq = Reference::getNumReferencesReq();
        for($i = 0; $i < $numRefsReq; $i++) {
            $refForm = new \PHPWS_Form('nomination_form'); // NB: Must have the same form name

            if($vis->isVisible('reference_first_name')) {
                if($edit && !UserStatus::isAdmin())
                {
                    $tpl['REFERENCE_FIRST_NAME_' . $i] = '<label>'. $c['reference_first_name'][$i] . '</label>';
                } else {
                    $form->addHidden('reference_id_' . $i, $c['reference_id'][$i]);
                    $form->addText('reference_first_name_' . $i,
                    isset($c['reference_first_name'][$i]) ? $c['reference_first_name'][$i] : '');
                    $form->addCssClass('reference_first_name_' . $i, 'form-control');
                }
            }

            if($vis->isVisible('reference_last_name')) {
                if($edit && !UserStatus::isAdmin())
                {
                    $tpl['REFERENCE_LAST_NAME_' . $i] = '<label>' . $c['reference_last_name'][$i] . '</label>';
                } else {
                    $form->addText('reference_last_name_' . $i,
                    isset($c['reference_last_name'][$i]) ? $c['reference_last_name'][$i] : '');
                    $form->addCssClass('reference_last_name_'. $i, 'form-control');
                }
            }

            if($vis->isVisible('reference_department')) {
                if($edit && !UserStatus::isAdmin()) {
                    $tpl['REFERENCE_DEPARTMENT_'.$i] = '<label>' . $c['reference_department'][$i] . '</label>';
                } else {
                    $form->addText('reference_department_' . $i,
                    isset($c['reference_department'][$i]) ? $c['reference_department'][$i] : '');
                    $form->addCssClass('reference_department_' . $i, 'form-control');
                }
            }

            if($vis->isVisible('reference_email')) {
                if($edit && !UserStatus::isAdmin()) {
                    $tpl['REFERENCE_EMAIL_'.$i] = '<label>' . $c['reference_email'][$i] . '</label>';
                } else {
                    $form->addText('reference_email_' . $i,
                    isset($c['reference_email'][$i]) ? $c['reference_email'][$i] : '');
                    $form->addCssClass('reference_email_' . $i, 'form-control');
                }
            }

            if($vis->isVisible('reference_phone')) {
                if($edit && !UserStatus::isAdmin()) {
                    $tpl['REFERENCE_PHONE_'.$i] = '<label>' . $c['reference_phone'][$i] . '</label>';
                } else {
                    $form->addText('reference_phone_' . $i,
                    isset($c['reference_phone'][$i]) ? $c['reference_phone'][$i] : '');
                    $form->addCssClass('reference_phone_' . $i, 'form-control');
                }
            }

            if($vis->isVisible('reference_relationship')) {
                if($edit && !UserStatus::isAdmin()) {
                    $tpl['REFERENCE_RELATIONSHIP_'.$i] = '<label>' . $c['reference_relationship'][$i] . '</label>';
                } else {
                    $form->addText('reference_relationship_' . $i,
                    isset($c['reference_relationship'][$i]) ? $c['reference_relationship'][$i] : '');
                    $form->addCssClass('reference_relationship_' . $i, 'form-control');
                }

            }

            $tpl['REFERENCES_REPEAT'][] = $refForm->getTemplate();
        }

        /*************
        * Statement *
        *************/
        if($vis->isVisible('statement')) {
            if(!isset($nomination)) {
                $tpl['FILES_DIR'] = PHPWS_SOURCE_HTTP;
                $tpl['STATEMENT'] = NominationDocument::getFileWidget(null, 'statement', $form);
            } else {
                //TODO fix editing
                //$omnom = new Nomination;
                //$omnom->id = $nomination->getId();
            }
        }

        /******************
        * Nominator Info *
        ******************/
        if($vis->isVisible('nominator_first_name')) {
            $form->addText('nominator_first_name',
            isset($c['nominator_first_name']) ? $c['nominator_first_name'] : '');
            $form->setLabel('nominator_first_name', 'Nominator\'s first name: ');
            $form->addCssClass('nominator_first_name', 'form-control');
        }

        if($vis->isVisible('nominator_middle_name')) {
            $form->addText('nominator_middle_name',
            isset($c['nominator_middle_name']) ? $c['nominator_middle_name'] : '');
            $form->setLabel('nominator_middle_name', 'Nominator\'s middle name: ');
            $form->addCssClass('nominator_middle_name', 'form-control');
        }

        if($vis->isVisible('nominator_last_name')) {
            $form->addText('nominator_last_name',
            isset($c['nominator_last_name']) ? $c['nominator_last_name'] : '');
            $form->setLabel('nominator_last_name', 'Nominator\'s last name: ');
            $form->addCssClass('nominator_last_name', 'form-control');
        }

        if($vis->isVisible('nominator_address')) {
            $form->addText('nominator_address',
            isset($c['nominator_address']) ? $c['nominator_address'] : '');
            $form->setLabel('nominator_address', 'ASU Address: ');
            $form->addCssClass('nominator_address', 'form-control');
        }

        if($vis->isVisible('nominator_phone')) {
            $form->addText('nominator_phone',
            isset($c['nominator_phone']) ? $c['nominator_phone'] : '');
            $form->setLabel('nominator_phone', 'ASU Telephone: ');
            $form->addCssClass('nominator_phone', 'form-control');
        }

        if($vis->isVisible('nominator_email')) {
            if($edit && !UserStatus::isAdmin())
            {
                $tpl['NOMINATOR_EMAIL'] = '<label>' . $c['nominator_email'] . '</label>';
            }
            else
            {
                $form->addText('nominator_email',
                isset($c['nominator_email']) ? $c['nominator_email'] : '');
                $form->addCssClass('nominator_email', 'form-control');
                $tpl['NOMINATOR_ADD_ON'] = '<div class="input-group-addon">@appstate.edu</div>';
            }
        }

        if($vis->isVisible('nominator_relationship')) {
            $form->addText('nominator_relationship', isset($c['nominator_relationship']) ? $c['nominator_relationship'] : '');
            $form->setLabel('nominator_relationship', 'Relation to Nominee: ');
            $form->addCssClass('nominator_relationship', 'form-control');
        }

        /***********
        * Captcha *
        ***********/

        $tpl['CAPTCHA_IMAGE'] = \Captcha::get();

        // Check if we were redirected back to this
        // form because some fields were not entered
        // If form_fail is true then it did fail
        if(isset($c['form_fail']) && $c['form_fail']){
            $vars = array('FIELDS' => json_encode($c['missing']),
            'PHPWS_SOURCE_HTTP' => PHPWS_SOURCE_HTTP);
            javascript('jquery_ui');
            javascriptMod('nomination', 'highlight', $vars);
        }

        $form->mergeTemplate($tpl);
        $tpl = $form->getTemplate();

        \Layout::addPageTitle('Nomination Form');

        $result = \PHPWS_Template::process($tpl, 'nomination', 'nomination_form.tpl');

        return $result;
    }
}
