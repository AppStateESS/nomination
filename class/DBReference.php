<?php
namespace nomination;

/**
 * An empty child class of Reference to allow restoring from the DB
 * without calling the parent class' constructor.
 *
 * @author jbooker
 * @package nomination
 */
class DBReference extends Reference {

    /**
     * Empty constructor to allow restoring from db.
     */
    public function __construct(){}
}
