<?php
/**
 * NominationForm - View class to handle creating the nomination form fields
 *
 * @author Robert Bost?
 * @author Jeremy Booker
 * @package nomination
 */

PHPWS_Core::initModClass('nomination', 'View.php');
PHPWS_Core::initModClass('nomination', 'NominationDocument.php');
PHPWS_Core::initModClass('nomination', 'CommandFactory.php');
PHPWS_Core::initModClass('nomination', 'FallthroughContext.php');
PHPWS_Core::initModClass('nomination', 'CancelQueue.php');

class NominationForm extends OmNomView
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
        PHPWS_Core::initModClass('nomination', 'Period.php');
        if(Period::isOver()){
            $currPeriod = Period::getCurrentPeriod();
            $end = $currPeriod->getReadableEndDate();
            return '<h2>The nomination ended on '.$end.'.</h2>';
        }
        else if(!Period::hasBegun()){
            $currPeriod = Period::getCurrentPeriod();
            $begin = $currPeriod->getReadableStartDate();
            return '<h2>The nomination period will begin on '.$begin.'.</h2>';
        }

        PHPWS_Core::initCoreClass('Form.php');

        $c = new FallthroughContext(array());
        $c->addFallthrough($context);

        /**
         * These forms are displayed if the Nominator is editing the nomination
        */
        if(isset($context['unique_id'])){
            //setup the fallthrough context
            $nomination = Nomination::getByNominatorUnique_Id($context['unique_id']);
            $c->addFallthrough($nomination);

            //...and add a button for the nominator to cancel their nomination
            // or remove the request to delete their nomination
            $cancelForm = new PHPWS_Form('cancel_nominationForm');

            if(CancelQueue::contains($nomination['id'])){
                $cmd = $cmdFactory->get('WithdrawCancelNomination');
                $cancelForm->addSubmit('Remove Request');
            } else {
                $cmd = $cmdFactory->get('CancelNomination');
                $cancelForm->addSubmit('Submit Request');
            }
            $cmd->unique_id = $context['unique_id'];
            $cmd->initForm($cancelForm);

            $tpl['cancel']['CANCEL_BUTTON'] = $cancelForm->getTemplate();

            // Resend email form
            $resendForm = new PHPWS_Form('resend_email_form');
            $users = array('nominator'=>'Nominator (self)', 'ref_1'=>'Reference 1',
                            'ref_2'=>'Reference 2', 'ref_3'=>'Reference 3');
            $resendForm->addCheckAssoc('users', $users);
            $resendForm->addSubmit('Submit');

            $resendCmd = $cmdFactory->get('ResendEmail');
            $resendCmd->setUniqueId($context['unique_id']);
            $resendCmd->initForm($resendForm);

            $tpl['resend']['RESEND_FORM'] = $resendForm->getTemplate();
        }

        $form = new PHPWS_Form('nomination_form');

        // Decide which submission command to use
        if(!isset($c['unique_id'])){
            $submitCmd = $cmdFactory->get('CreateNomination');
        } else {
            $submitCmd = $cmdFactory->get('EditNomination');
            $submitCmd->unique_id = $c['unique_id'];
        }

        $submitCmd->initForm($form);

        $tpl['AWARD_TITLE'] = PHPWS_Settings::get('nomination', 'award_title');
        $currPeriod = Period::getCurrentPeriod();
        $tpl['PERIOD_END'] = $currPeriod->getReadableEndDate();
        $tpl['NUM_REFS'] = PHPWS_Settings::get('nomination', 'num_references_req');


        PHPWS_Core::initModClass('nomination', 'NominationFieldVisibility.php');
        $vis = new NominationFieldVisibility();

        /****************
         * Nominee Info *
        ****************/
        //TODO: Make some of these configuable so we can show/hide them from settings
        $form->addText('nominee_first_name',
                        isset($c['nominee_first_name']) ? $c['nominee_first_name'] : '');
        $form->setLabel('nominee_first_name', 'First name');

        $form->addText('nominee_middle_name',
                        isset($c['nominee_middle_name']) ? $c['nominee_middle_name'] : '');
        $form->setLabel('nominee_middle_name', 'Middle name');

        $form->addText('nominee_last_name',
                        isset($c['nominee_last_name']) ? $c['nominee_last_name'] : '');
        $form->setLabel('nominee_last_name', 'Last name');

        $form->addText('nominee_email',
                        isset($c['nominee_email']) ? $c['nominee_email'] : '');
        $form->setLabel('nominee_email', 'ASU Email');

        if($vis->isVisible('nominee_asubox')) {
            $form->addText('nominee_asubox',
                            isset($c['nominee_asubox']) ? $c['nominee_asubox'] : '');
            $form->setLabel('nominee_asubox', 'ASU Box');
        }

        if($vis->isVisible('nominee_position')) {
            $form->addText('nominee_position',
                            isset($c['nominee_position']) ? $c['nominee_position'] : '');
            $form->setLabel('nominee_position', 'Position on Campus');
        }

        if($vis->isVisible('nominee_department_major')) {
            $form->addText('nominee_department_major',
                            isset($c['nominee_major']) ? $c['nominee_major'] : '');
            $form->setLabel('nominee_department_major', 'Department/Major');
        }

        if($vis->isVisible('nominee_years')) {
            $form->addText('nominee_years',
                            isset($c['nominee_years']) ? $c['nominee_years'] : '');
            $form->setLabel('nominee_years', 'Years at Appalachian');
        }

        if($vis->isVisible('nominee_responsibility')) {
            $form->addRadioAssoc('nominee_responsibility', array(1=>'Yes',2=>'No'));
            if(isset($c['nominee_responsibility']))
                $form->setMatch('nominee_responsibility', $c['nominee_responsibility']);
        }

        if($vis->isVisible('nominee_banner_id')) {
            $form->addText('nominee_banner_id');
            $form->setlabel('nominee_banner_id', 'Banner ID');
        }
        if($vis->isVisible('nominee_phone')) {
            $form->addText('nominee_phone');
            $form->setLabel('nominee_phone', 'Phone Number');
        }
        if($vis->isVisible('nominee_gpa')) {
            $form->addText('nominee_gpa');
            $form->setLabel('nominee_gpa', 'GPA');
        }
        if($vis->isVisible('nominee_class')) {
            $form->addDropBox('nominee_class', array(-1=>'Select', 'fr'=>'Freshmen', 'so'=>'Sophomore', 'jr'=>'Junior', 'sr'=>'Senior', 'grad'=>'Graudate'));
            $form->setMatch('nominee_class', -1);
            $form->setLabel('nominee_class', 'Class');
        }


        /************
         * Category *
        ************/
        if($vis->isVisible('category')) {
            $category_radio = array(APP_STUDENT_CONDUCT_BOARD, APP_ACADEMIC_INTEGRITY_BOARD, APP_BOTH);
            $form->addRadio('category', $category_radio);
            $form->setMatch('category', isset($c['category']) ? $c['category'] : APP_STUDENT_CONDUCT_BOARD);
        }

        /*************
         * Refernces *
        *************/
        //TODO: fix reference editing

        /**
         * NB: Field names are sensitive and done this way on purpose
         * so that multiple fields with the same name can be submitted.
         */
        $numRefsReq = Reference::getNumReferencesReq();
        for($i = 1; $i <= $numRefsReq; $i++){
            $refForm = new PHPWS_Form('nomination_form'); // NB: Must have the same form name

            if($vis->isVisible('reference_first_name')) {
                $refForm->addText('reference_first_name[]',
                                isset($c['reference_first_name_'.$i]) ? $c['reference_first_name_'.$i] : '');
                $refForm->setLabel('reference_first_name[]', 'First Name: ');
            }

            if($vis->isVisible('reference_last_name')) {
                $refForm->addText('reference_last_name[]',
                                isset($c['reference_last_name_'.$i]) ? $c['reference_last_name_'.$i] : '');
                $refForm->setLabel('reference_last_name[]', 'Last Name: ');
            }

            if($vis->isVisible('reference_department')) {
                $refForm->addText('reference_department[]', isset($c['reference_department_'.$i]) ? $c['reference_department_'.$i] : '');
                $refForm->setLabel('reference_department[]', 'Department: ');
            }

            if($vis->isVisible('reference_email')) {
                $refForm->addText('reference_email[]', isset($c['reference_email_'.$i]) ? $c['reference_email_'.$i] : '');
                $refForm->setLabel('reference_email[]', 'Email: ');
            }

            if($vis->isVisible('reference_phone')) {
                $refForm->addText('reference_phone[]', isset($c['reference_phone_'.$i]) ? $c['reference_phone_'.$i] : '');
                $refForm->setLabel('reference_phone[]', 'Telephone: ');
            }

            if($vis->isVisible('reference_relationship')) {
                $refForm->addText('reference_relationship[]', isset($c['reference_relationship_'.$i]) ? $c['reference_relationship_'.$i] : '');
                $refForm->setLabel('reference_relationship[]', 'Relation to Nominee: ');
            }

            $tpl['REFERENCES_REPEAT'][] = $refForm->getTemplate();
        }

        /*********************
         * Document Download *
         */

        $tpl['FILES_DIR'] = PHPWS_SOURCE_HTTP;

        /*************
         * Statement *
        *************/
        if($vis->isVisible('statement')) {
            if(!isset($nomination)){
                //$upload = new NominationDocument();
                $tpl['STATEMENT'] = NominationDocument::getFileWidget(null, 'statement', $form);
            } else {
                //TODO fix editing
                $omnom = new Nomination;
                $omnom->id = $nomination['id'];
                $omnom->load();
                $upload = new NominationDocument($omnom);
                $nominator = new Nominator($omnom->nominator_id);
                $omnom->doc_id = $nominator->doc_id;
                $tpl['STATEMENT'] = $upload->getFileWidget('statement', $form,
                                $context['unique_id']);
            }
        }

        /******************
         * Nominator Info *
        ******************/
        if($vis->isVisible('nominator_first_name')) {
            $form->addText('nominator_first_name',
                            isset($c['nominator_first_name']) ? $c['nominator_first_name'] : '');
            $form->setLabel('nominator_first_name', 'Nominator\'s first name: ');
        }

        if($vis->isVisible('nominator_middle_name')) {
            $form->addText('nominator_middle_name',
                            isset($c['nominator_middle_name']) ? $c['nominator_middle_name'] : '');
            $form->setLabel('nominator_middle_name', 'Nominator\'s middle name: ');
        }

        if($vis->isVisible('nominator_last_name')) {
            $form->addText('nominator_last_name',
                            isset($c['nominator_last_name']) ? $c['nominator_last_name'] : '');
            $form->setLabel('nominator_last_name', 'Nominator\'s last name: ');
        }

        if($vis->isVisible('nominator_address')) {
            $form->addText('nominator_address',
                            isset($c['nominator_address']) ? $c['nominator_address'] : '');
            $form->setLabel('nominator_address', 'ASU Address: ');
        }

        if($vis->isVisible('nominator_phone')) {
            $form->addText('nominator_phone',
                            isset($c['nominator_phone']) ? $c['nominator_phone'] : '');
            $form->setLabel('nominator_phone', 'ASU Telephone: ');
        }

        if($vis->isVisible('nominator_email')) {
            $form->addText('nominator_email',
                            isset($c['nominator_email']) ? $c['nominator_email'] : '');
            $form->setLabel('nominator_email', 'ASU E-Mail: ');
        }

        if($vis->isVisible('nominator_relationship')) {
            $form->addText('nominator_relationship', isset($c['nominator_relationship']) ? $c['nominator_relationship'] : '');
            $form->setLabel('nominator_relationship', 'Relation to Nominee: ');
        }

        // Check if we were redirected back to this
        // form because some fields were not entered
        // If form_fail is true then it did fail
        if(isset($c['form_fail']) && $c['form_fail']){
            $vars = array('FIELDS' => json_encode($c['missing']),
                            'PHPWS_SOURCE_HTTP' => PHPWS_SOURCE_HTTP);
            javascript('jquery_ui');
            javascriptMod('nomination', 'highlight', $vars);
        }

        $form->addSubmit('submit', 'Submit');

        // Showtime!
        $form->mergeTemplate($tpl);
        $tpl = $form->getTemplate();

        Layout::addPageTitle('Nomination Form');

        $result = PHPWS_Template::process($tpl, 'nomination', 'nomination_form.tpl');

        return $result;
    }
}
?>
