<?php
  /**
   * AdminSettings
   *
   * View for administrative settings
   *
   * @author Daniel West <dwest at tux dot appstate dot edu>
   * @author Robert Bost <bostrt at tux dot appstate dot edu>
   */

PHPWS_Core::initModClass('nomination', 'View.php');
PHPWS_Core::initModClass('nomination', 'CommandFactory.php');
PHPWS_Core::initModClass('nomination', 'ViewFactory.php');
PHPWS_Core::initModClass('nomination', 'Reference.php');
PHPWS_Core::initModClass('nomination', 'NominationDocument.php');

class AdminSettings extends \nomination\View {

    public function getRequestVars()
    {
        return array('view' => 'AdminSettings');
    }

    public function display(Context $context)
    {
        if(!UserStatus::isAdmin()){
            throw new PermissionException('You are not allowed to see this!');
        }
        $tpl = array();

        // Create factories
        $cmdFactory = new CommandFactory();
        $vFactory = new ViewFactory();

        // Initialize form submit command
        $updateCmd = $cmdFactory->get('UpdateSettings');
        $form = new PHPWS_Form('admin_settings');
        $updateCmd->initForm($form);

        // Award title
        $form->addText('award_title', PHPWS_Settings::get('nomination', 'award_title'));
        $form->setLabel('award_title', 'Award Title:');
        $form->setSize('award_title', 30);
        $form->addCssClass('award_title', 'form-control');

        // Number of references required
        $numRefs = PHPWS_Settings::get('nomination', 'num_references_req');
        $form->addText('num_references_req', isset($numRefs)?$numRefs:1);  // Default to 1 required reference
        $form->setLabel('num_references_req', '# References Required');
        $form->setSize('num_references_req', 3);
        $form->setMaxSize('num_references_req', 1);
        $form->addCssClass('num_references_req', 'form-control');

        // File storage path
        $form->addText('file_dir', PHPWS_Settings::get('nomination', 'file_dir'));
        $form->setLabel('file_dir', 'File Directory:');
        $form->setSize('file_dir', 30);
        $form->addCssClass('file_dir', 'form-control');

        // Allowed file types
        $types = NominationDocument::getFileNames();
        $enabled = unserialize(PHPWS_Settings::get('nomination', 'allowed_file_types'));
        $form->addCheckAssoc('allowed_file_types', $types);
        $form->setMatch('allowed_file_types', $enabled);
        $form->useRowRepeat();

        // Email from address
        $form->addText('email_from_address', PHPWS_Settings::get('nomination', 'email_from_address'));
        $form->setLabel('email_from_address', 'Email From Address');
        $form->setSize('email_from_address', 30);
        $form->addCssClass('email_from_address', 'form-control');

        // Hidden Fields
        PHPWS_Core::initModClass('nomination', 'NominationFieldVisibility.php');
        $vis = new NominationFieldVisibility();
        $vis->prepareSettingsForm($form, 'show_fields');

        $form->addSubmit('Update');

        $form->useRowRepeat();
        $form->mergeTemplate($tpl);
        $tpl = $form->getTemplate();

        Layout::addPageTitle('Admin Settings');

        return PHPWS_Template::process($tpl, 'nomination', 'admin/settings.tpl');
    }
}
?>
