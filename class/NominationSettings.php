<?php

namespace nomination;


/**
 * Singleton object for storing Nomination Settings
 *
 * @author jbooker
 * @package nomination
 */
class NominationSettings {

    private static $instance;

    /**
     * Private constructor for singleton pattern
     */
    private function __construct()
    {
    }

    /**
     * Returns as instance of nominationSettings
     *
     * @return nominationSettings
     */
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new NominationSettings();
        }

        return self::$instance;
    }

    public function getAwardTitleForEmail()
    {
        $result = \PHPWS_Settings::get('nomination', 'award_title');

        if (!isset($result) || is_null($result)) {
            throw new \InvalidArgumentException('Missing configuration for Award Title.');
        }

        return $result;
    }

    public function getSignatureForEmail()
    {
        $result = \PHPWS_Settings::get('nomination', 'signature');

        if (!isset($result) || is_null($result)) {
            throw new \InvalidArgumentException('Missing configuration for Signature.');
        }

        return $result;
    }

    public function getSigPositionEmail()
    {
        $result = \PHPWS_Settings::get('nomination', 'sig_position');

        if (!isset($result) || is_null($result)) {
            throw new \InvalidArgumentException('Missing configuration for Signature Position.');
        }

        return $result;
    }

    public function getEmailFromAddress()
    {
       $result = \PHPWS_Settings::get('nomination', 'email_from_address');

       if (!isset($result) || is_null($result)) {
           throw new \InvalidArgumentException('Missing configuration for Email From Address.');
       }

       return $result;
    }

}
