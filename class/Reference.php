<?php

namespace nomination;

use nomination\view\ReferenceView;

/**
 * Reference
 *
 * Represents a single reference for a nomination.
 *
 * @author Allison Nelson <allison at tux dot appstate dot edu>
 * @author Jeremy Booker
 * @package nomination
 */
class Reference
{

    private $id;
    private $nominationId; // Foreign key to the nomination table
    private $firstName;
    private $lastName;
    private $email; // Fully-qualified email address
    private $phone;
    private $department;
    private $relationship;
    private $uniqueId;
    private $docId;

    public function __construct(Nomination $nomination, $first_name, $last_name,
            $email, $phone, $department, $relationship)
    {

        $this->setNominationId($nomination->getId());

        $this->setFirstName($first_name);
        $this->setLastName($last_name);
        $this->setEmail($email);
        $this->setPhone($phone);
        $this->setDepartment($department);
        $this->setRelationship($relationship);

        $emailParts = explode('@', $email);
        $this->uniqueId = self::generateUniqueId($emailParts[0]);

        //$this->docId = $doc_id; // This is set later, when the ref uploads something
    }

    /**
     * Get the link for a nominator to edit their nomination
     * @return URL for submitting letter
     */
    public function getEditLink()
    {
        //TODO: Use a command?
        $link = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . '?module=nomination&view=ReferenceForm&unique_id=' . $this->getUniqueId();

        return $link;
    }

    /*     * *************************
     * Getter & Setter Methods *
     * ************************* */

    public static function getDb()
    {
        return new \PHPWS_DB('nomination_reference');
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getFullName()
    {
        return $this->getFirstName() . ' ' . $this->getLastName();
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getDepartment()
    {
        return $this->department;
    }

    public function getRelationship()
    {
        return $this->relationship;
    }

    public function getUniqueId()
    {
        return $this->uniqueId;
    }

    public function getDocId()
    {
        return $this->docId;
    }

    public function getNominationId()
    {
        return $this->nominationId;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Setters...
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setFirstName($name)
    {
        $this->firstName = substr($name, 0, 64);
    }

    public function setLastName($name)
    {
        $this->lastName = substr($name, 0, 64);
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPhone($phone)
    {
        $this->phone = substr(preg_replace('/\D/', '', $phone), 0, 32);
    }

    public function setDepartment($department)
    {
        $this->department = substr($department, 0, 64);
    }

    public function setRelationship($relationship)
    {
        $this->relationship = $relationship;
    }

    public function setUniqueId($id)
    {
        $this->uniqueId = $id;
    }

    public function setDocId($doc_id)
    {
        $this->docId = $doc_id;
    }

    public function setNominationId($id)
    {
        $this->nominationId = $id;
    }

    //gets a link to the nominee
    public function getReferenceLink()
    {
        $view = new ReferenceView();
        //we need this so we can see the id later

        $view->setReferenceId($this->id);
        $name = $this->getFullName();
        $link = $view->getLink($name);
        return $link;
    }

    /**
     * Static Utility methods
     */

    /**
     * Username acts as salt.
     * Useranme is prepended to a unique id based on
     * current time in microseconds.
     *
     * @return unique_id
     */
    public static function generateUniqueId($username)
    {
        return md5(uniqid($username));
    }

    /**
     * Returns the number of references required (as set in the mod's settings)
     *
     * @return int Number of references required.
     */
    public static function getNumReferencesReq()
    {
        return \PHPWS_Settings::get('nomination', 'num_references_req');
    }

}
