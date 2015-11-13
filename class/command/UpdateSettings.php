<?php
namespace nomination\command;

use \nomination\Command;
use \nomination\Context;
use \nomination\view\NotificationView;
use \nomination\exception\InvalidSettingsException;
use \nomination\UserStatus;
use \nomination\NominationFieldVisibility;

/**
 * UpdateSettings - Controller class to handle saving module settings.
 *
 * @author bost?
 * @author Jeremy Booker
 * @package nomination
 */
class UpdateSettings extends Command {

    public function getRequestVars(){
        return array('action' => 'UpdateSettings', 'after' => 'AdminSettings');
    }

    public function getNominationFields()
    {
        return array('nominee_asubox',
                     'nominee_position',
                     'nominee_first_name',
				     'nominee_last_name',
                     'nominee_department_major',
                     'nominee_years',
                     'nominee_responsibility',
                     'nominee_banner_id',
                     'nominee_phone',
                     'nominee_gpa',
                     'nominee_class',
                     'category',
                     'reference_department',
                     'reference_email',
                     'reference_phone',
                     'reference_relationship',
                     'statement',
                     'nominator_first_name',
                     'nominator_middle_name',
                     'nominator_last_name',
                     'nominator_address',
                     'nominator_phone',
                     'nominator_email',
                     'nominator_relationship');
    }

    public function execute(Context $context)
    {
        if(!UserStatus::isAdmin()){
            throw new \nomination\exception\PermissionException('You are not allowed to see this!');
        }

        try{
            // Store settings in a map
            $settingsMap = array();

            /*
             * Update award title
             */
            if(!empty($context['award_title'])){
                $settingsMap['award_title'] = $context['award_title'];
            }

            /*
             * Update References Required
             */
            if(!empty($context['num_references_req'])){
                $settingsMap['num_references_req'] = $context['num_references_req'];
            }

            /*
             * Update file storage path
             */
            if(!empty($context['file_dir'])){
                // Check for trailing '/'
                $file_dir = $context['file_dir'];
                if($file_dir[strlen($file_dir)-1] != '/'){
                    // Append '/' if it does not exist
                    $file_dir .= "/";
                }
                $settingsMap['file_dir'] = $file_dir;
            }

            /**
             * Update allowed file types for upload
             */
            if(!empty($context['allowed_file_types'])){
                $settingsMap['allowed_file_types'] = $context['allowed_file_types'];
            } else {
                throw new \nomination\exception\InvalidSettingsException('At least one file type must be set.');
            }

            $settingsMap['email_from_address'] = $context['email_from_address'];

            $vis = new NominationFieldVisibility();
            $vis->saveFromContext($context, 'show_fields');

            /**
             * Actually perform updates now
             * PHPWS_Settings::save() returns null on success
             */
            foreach($settingsMap as $key=>$value){
                \PHPWS_Settings::set('nomination', $key, $value);
            }
            $result = \PHPWS_Settings::save('nomination');

            if(!is_null($result)){
                throw new \Exception('Something bad happened when settings were being saved.');
            }
        } catch (\Exception $e){
            \NQ::simple('nomination', NotificationView::NOMINATION_ERROR, $e->getMessage());
            return;
        }


        \NQ::simple('nomination', NotificationView::NOMINATION_SUCCESS, 'Settings saved.');
    }

}
