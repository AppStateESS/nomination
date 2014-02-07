<?php

function nomination_update($content, $currentVersion)
{
    switch($currentVersion){
        case version_compare($currentVersion, '0.0.2', '<'):
            $db = new PHPWS_DB;
            $result = $db->importFile(PHPWS_SOURCE_DIR .
                            'mod/nomination/boost/updates/update_0_0_2.sql');
            if(PHPWS_Error::logIfError($result)){
                return $result;
            }
            PHPWS_Core::initModClass('users', 'Permission.php');
            Users_Permission::registerPermissions('nomination', $content);
        case version_compare($currentVersion, '0.0.3', '<'):
            $db = new PHPWS_DB;
            $result = $db->importFile(PHPWS_SOURCE_DIR .
                            'mod/nomination/boost/updates/update_0_0_3.sql');
            if(PHPWS_Error::logIfError($result)){
                return $result;
            }
        case version_compare($currentVersion, '0.0.4', '<'):
            $db = new PHPWS_DB;
            $result = $db->importFile(PHPWS_SOURCE_DIR .
                            'mod/nomination/boost/updates/update_0_0_4.sql');
            if(PHPWS_Error::logIfError($result)){
                return $result;
            }
        case version_compare($currentVersion, '0.0.5', '<'):
            $db = new PHPWS_DB;
            $result = $db->importFile(PHPWS_SOURCE_DIR .
                            'mod/nomination/boost/updates/update_0_0_5.sql');
            if(PHPWS_Error::logIfError($result)){
                return $result;
            }
        case version_compare($currentVersion, '0.0.6', '<'):
            $db = new PHPWS_DB;
            $result = $db->importFile(PHPWS_SOURCE_DIR .
                            'mod/nomination/boost/updates/update_0_0_6.sql');
            if(PHPWS_Error::logIfError($result)){
                return $result;
            }
        case version_compare($currentVersion, '0.0.7', '<'):
            $db = new PHPWS_DB;
            $result = $db->importFile(PHPWS_SOURCE_DIR .
                            'mod/nomination/boost/updates/update_0_0_7.sql');
            if(PHPWS_Error::logIfError($result)){
                return $result;
            }
        case version_compare($currentVersion, '0.0.8', '<'):
            $db = new PHPWS_DB;
            $result = $db->importFile(PHPWS_SOURCE_DIR .
                            'mod/nomination/boost/updates/update_0_0_8.sql');
            if(PHPWS_Error::logIfError($result)){
                return $result;
            }
        case version_compare($currentVersion, '0.0.9', '<'):
            $db = new PHPWS_DB;
            $result = $db->importFile(PHPWS_SOURCE_DIR .
                            'mod/nomination/boost/updates/update_0_0_9.sql');
            if(PHPWS_Error::logIfError($result)){
                return $result;
            }
        case version_compare($currentVersion, '0.0.10', '<'):
            $db = new PHPWS_DB;
            $result = $db->importFile(PHPWS_SOURCE_DIR .
                            'mod/nomination/boost/updates/update_0_0_10.sql');
            if(PHPWS_Error::logIfError($result)){
                return $result;
            }
        case version_compare($currentVersion, '0.0.11', '<'):
            $db = new PHPWS_DB;
            $result = $db->importFile(PHPWS_SOURCE_DIR .
                            'mod/nomination/boost/updates/update_0_0_11.sql');
            if(PHPWS_Error::logIfError($result)){
                return $result;
            }
        case version_compare($currentVersion, '0.0.12', '<'):
            $db = new PHPWS_DB;
            $result = $db->importFile(PHPWS_SOURCE_DIR .
                            'mod/nomination/boost/updates/update_0_0_12.sql');
            if(PHPWS_Error::logIfError($result)){
                return $result;
            }
        case version_compare($currentVersion, '0.0.13', '<'):
            $db = new PHPWS_DB;
            $result = $db->importFile(PHPWS_SOURCE_DIR .
                            'mod/nomination/boost/updates/update_0_0_13.sql');
            if(PHPWS_Error::logIfError($result)){
                return $result;
            }
        case version_compare($currentVersion, '0.0.14', '<'):
            $db = new PHPWS_DB;
            $result = $db->importFile(PHPWS_SOURCE_DIR .
                            'mod/nomination/boost/updates/update_0_0_14.sql');
            if(PHPWS_Error::logIfError($result)){
                return $result;
            }
        case version_compare($currentVersion, '0.0.15', '<'):
            $db = new PHPWS_DB;
            $result = $db->importFile(PHPWS_SOURCE_DIR .
                            'mod/nomination/boost/updates/update_0_0_15.sql');
            if(PHPWS_Error::logIfError($result)){
                return $result;
            }
        case version_compare($currentVersion, '0.0.16', '<'):
            $db = new PHPWS_DB;
            $result = $db->importFile(PHPWS_SOURCE_DIR .
                            'mod/nomination/boost/updates/update_0_0_16.sql');
            if(PHPWS_Error::logIfError($result)){
                return $result;
            }
        case version_compare($currentVersion, '0.0.17', '<'):
            $db = new PHPWS_DB;
            $result = $db->importFile(PHPWS_SOURCE_DIR .
                            'mod/nomination/boost/updates/update_0_0_17.sql');
            if(PHPWS_Error::logIfError($result)){
                return $result;
            }
        case version_compare($currentVersion, '0.0.18', '<'):
            $db = new PHPWS_DB;
            $result = $db->importFile(PHPWS_SOURCE_DIR .
                            'mod/nomination/boost/updates/update_0_0_18.sql');
            if(PHPWS_Error::logIfError($result)){
                return $result;
            }
        case version_compare($currentVersion, '0.0.19', '<'):
            $db = new PHPWS_DB;
            $result = $db->importFile(PHPWS_SOURCE_DIR .
                            'mod/nomination/boost/updates/update_0_0_19.sql');
            echo '<pre>';
            print_r($result);
            echo '</pre>';
            if(PHPWS_Error::logIfError($result)){
                return $result;
            }

        case version_compare($currentVersion, '0.0.20', '<'):
            $db = new PHPWS_DB;
            $result = $db->importFile(PHPWS_SOURCE_DIR .
                            'mod/nomination/boost/updates/update_0_0_20.sql');
            if(PHPWS_Error::logIfError($result)) {
                return $result;
            }

        case version_compare($currentVersion, '0.0.21', '<'):
            $db = new PHPWS_DB;
            $result = $db->importFile(PHPWS_SOURCE_DIR .
                            'mod/nomination/boost/updates/update_0_0_21.sql');
            if(PHPWS_Error::logIfError($result)) {
                return $result;
            }
        case version_compare($currentVersion, '0.0.22', '<'):
            $db = new PHPWS_DB;
            $result = $db->importFile(PHPWS_SOURCE_DIR .
                            'mod/nomination/boost/updates/update_0_0_22.sql');
            if(PHPWS_Error::logIfError($result)) {
                return $result;
            }
        case version_compare($currentVersion, '0.0.23', '<'):
            $db = new PHPWS_DB;
            $result = $db->importFile(PHPWS_SOURCE_DIR .
                            'mod/nomination/boost/updates/update_0_0_23.sql');
            if(PHPWS_Error::logIfError($result)) {
                return $result;
            }
    }
    return TRUE;
}

?>
