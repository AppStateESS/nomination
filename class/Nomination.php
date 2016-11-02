<?php
namespace nomination;

use \nomination\view\NomineeView;
use \nomination\view\NominatorView;

/**
 * Nomination
 *
 * Model class for representing a nomination.
 *
 * @author Jeremy Booker
 * @package nomination
 */

class Nomination
{
    public $id;

    // Nominee information
    public $banner_id;
    public $first_name;
    public $middle_name;
    public $last_name;
    public $asubox;
    public $email;
    public $position;
    public $department_major; // and/or Major
    public $years_at_asu;
    public $phone;
    public $gpa;
    public $class; // freshmen, sophomore, junior, senior
    public $responsibility;    // have they done a bad or not


    // Nominator information
    public $nominator_first_name;
    public $nominator_middle_name;
    public $nominator_last_name;
    public $nominator_address;
    public $nominator_phone;
    public $nominator_email;
    public $nominator_relation;
    private $nominatorUniqueId; // Unused so far, but needed for nomination editing


    // Nomination metadata
    private $category;
    private $period;

    private $complete;
    private $winner;
    private $added_on;
    private $updated_on;


    public function __construct($bannerId, $firstName, $middleName, $lastName, $email, $asubox, $position, $department, $yearsAtASU, $phone, $gpa, $class, $responsibility,
                    $nominatorFirstName, $nominatorMiddleName, $nominatorLastName, $nominatorAddress, $nominatorPhone, $nominatorEmail, $nominatorRelation, $nominatorUniqueId,
                    $category, $period){

        $this->banner_id        = $bannerId;
        $this->first_name       = $firstName;
        $this->middle_name      = $middleName;
        $this->last_name        = $lastName;
        $this->email            = $email;
        $this->position         = $position;
        $this->department_major = $department;
        $this->years_at_asu     = $yearsAtASU;
        $this->phone            = $phone;
        $this->gpa              = $gpa;
        $this->class            = $class;
        $this->asubox           = $asubox;
        $this->responsibility   = $responsibility; // just to make you cringe buddy!

        $this->nominator_first_name  = $nominatorFirstName;
        $this->nominator_middle_name = $nominatorMiddleName;
        $this->nominator_last_name   = $nominatorLastName;
        $this->nominator_address     = $nominatorAddress;
        $this->nominator_phone       = $nominatorPhone;
        $this->nominator_email       = $nominatorEmail;
        $this->nominator_relation    = $nominatorRelation;
        $this->nominatorUniqueId     = $nominatorUniqueId;

        $this->category = $category;
        $this->period   = $period;

        $this->complete = 0;
        $this->winner = 0;
        $currTime = time();
        $this->added_on = $currTime;
        $this->updated_on = $currTime;
    }

    /**
     * Getter & Setters
     */
    public static function getDb(){
      return new \PHPWS_DB('nomination_nomination');
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getBannerId(){
        return $this->banner_id;
    }

    public function setBannerId($id){
        $this->banner_id = $id;
    }

    public function getFirstName(){
        return $this->first_name;
    }

    public function setFirstName($name){
        $this->first_name = $name;
    }

    public function getMiddleName(){
        return $this->middle_name;
    }

    public function setMiddleName($name){
        $this->middle_name = $name;
    }

    public function getLastName(){
        return $this->last_name;
    }

    public function setLastName($name){
        $this->last_name = $name;
    }

    public function getFullName() {
        return $this->getFirstName() . ' ' . $this->getLastName();
    }

    public function getAsubox() {
        return $this->asubox;
    }

    public function setAsubox($asubox) {
        $this->asubox = $asubox;
    }

    public function getEmail(){
        return $this->email;
    }

    // Assumes email address is stored without domain,
    // and all addresses belong to the @appstate.edu domain
    public function getEmailLink(){
        $email = $this->email . "@appstate.edu";
        return "<a href='mailto:$email'>$email</a>";
    }

    public function setEmail($addr){
        $this->email = $addr;
    }

    public function getPosition(){
        return $this->position;
    }

    public function setPosition($pos){
        $this->position = $pos;
    }

    public function getDeptMajor(){
        return $this->department_major;
    }

    public function setDeptMajor($dept){
        $this->department_major = $dept;
    }

    public function getYearsAtASU(){
        return $this->years_at_asu;
    }

    public function setYearsAtASU($num){
        $this->years_at_asu = $num;
    }

    public function getPhone(){
        return $this->phone;
    }

    public function setPhone($phone){
        $this->phone = $phone;
    }

    public function getGpa(){
        return $this->gpa;
    }

    public function setGpa($gpa){
        $this->gpa = $gpa;
    }

    public function getClass(){
        return $this->class;
    }

    public function setClass($class){
        $this->class = $class;
    }

    public function setResponsibility($responsibility) {
        $this->responsibility = $responsibility;
    }

    public function getResponsibility() {
        return $this->responsibility;
    }

    public function getNominatorFirstName(){
        return $this->nominator_first_name;
    }

    public function setNominatorFirstName($name){
        $this->nominator_first_name = $name;
    }

    public function getNominatorMiddleName(){
        return $this->nominator_middle_name;
    }

    public function setNominatorMiddleName($name){
        $this->nominator_middle_name = $name;
    }

    public function getNominatorLastName(){
        return $this->nominator_last_name;
    }

    public function setNominatorLastName($name){
        $this->nominator_last_name = $name;
    }

    public function getNominatorFullName() {
        return $this->getNominatorFirstName() . ' ' . $this->getNominatorLastName();
    }

    public function getNominatorAddress(){
        return $this->nominator_address;
    }

    public function setNominatorAddress($address){
        $this->nominator_address = $address;
    }

    public function getNominatorPhone(){
        return $this->nominator_phone;
    }

    public function setNominatorPhone($phone){
        $this->nominator_phone = $phone;
    }

    public function getNominatorEmail(){
        return $this->nominator_email;
    }

    // Assumes email address is stored without domain,
    // and all addresses belong to the @appstate.edu domain
    public function getNominatorEmailLink(){
        $email = $this->nominator_email . "@appstate.edu";
        return "<a href='mailto:$email'>$email</a>";
    }

    public function setNominatorEmail($address){
        $this->nominator_email = $address;
    }


    public function getNominatorRelation(){
        return $this->nominator_relation;
    }

    public function setNominatorRelation($relation){
        $this->nominator_relation = $relation;
    }

    public function getCategory(){

        return $this->category;
    }

    public function setCategory($cat) {
        $this->category = $cat;
    }

    public function getPeriod(){
        return $this->period;
    }

    public function setPeriod($p) {
        $this->period = $p;
    }

    public function getComplete(){
        return $this->complete;
    }

    /**
     * Marks this nomination as complete.
     * @param boolean $comp
     */
    public function setComplete($comp) {
        if($comp){
            $this->complete = 1;
        }else{
            $this->complete = 0;
        }
    }

    public function getWinner(){
        return $this->winner;
    }

    public function isWinner()
    {
        if(($this->winner)==0){
            return False;
        } else {
            return True;
        }
    }

    public function setWinner($win) {
        if($win === '1'){
            $this->winner = 1;
        }else{
            $this->winner = 0;
        }
    }

    public function getAddedOn(){
        return $this->added_on;
    }

    public function getReadableAddedOn(){
        return strftime("%B %d, %Y", $this->getAddedOn());
    }

    public function setAddedOn($time) {
        $this->added_on = $time;
    }

    public function getUpdatedOn(){
        return $this->updated_on;
    }

    public function getReadableUpdatedOn(){
        return strftime("%B %d, %Y", $this->getUpdatedOn());
    }

    public function setUpdatedOn($time) {
        $this->updated_on = $time;
    }

    public function getUniqueId()
    {
      return $this->nominatorUniqueId;
    }

    public function setNominatorUniqueId($uniqueId)
    {
      $this->nominatorUniqueId = $uniqueId;
    }

    /**
     * Username acts as salt.
     * Username is prepended to a unique id based on
     * current time in microseconds.
     *
     * @return unique_id
     */
    public static function generateUniqueId($banner)
    {
        $uniqueId = md5(uniqid($banner));
        return $uniqueId;
    }



    /**
     * Get the link for a nominator to edit their nomination
     * @return URL for editting nomination
     */
    public function getEditLink()
    {
        $unique_id = $this->getUniqueId();

        $host = $_SERVER['HTTP_HOST'];
        $extra = $_SERVER['PHP_SELF'].'?module=nomination&view=NominationForm&unique_id=' . $unique_id;

        $link = 'http://'.$host.$extra;

        return $link;
    }

    /**
     * Utilities
     */

    public function checkCompletion()
    {
        //we need to check if this nomination is complete
        // 1. has each reference uploaded a document?
        $ref = new ReferenceFactory();

        //grab the references attached to this
        $references = $ref->getByNominationId($this->id);

        // foreach reference in references
        //   do they have a doc?
        //   if everyone has a doc then its complete
        foreach($references as $ref){
            if($ref->getDocId() == NULL)
                return false;
        }
        return true;

    }
    /**
     *  Get link to view nomination
     *  Default text is nominator name and submission date
     */
    public function getLink($text=null){
        $nominator = new Nominator;
        $nominator->id = $this->nominator_id;
        $nominator->load();

        $name = $nominator->getFullName();

        $view = new NominationView;
        $view->nominationId = $this->id;

        if(is_null($text)){
            $link = $view->getLink($name.' - '.strftime("%B %d, %Y", $nominator->getSubmissionDate()));

        } else {
            $link = $view->getLink($text);
        }

        return $link;
    }
    //gets a link to the nominee
    public function getNomineeLink(){
        $view = new NomineeView();
        //we need this so we can see the id later
        $view->setNominationId($this->id);
        $name = $this->getFullName();
        $link = $view->getLink($name);
        return $link;
    }

    public function getNominatorLink() {
        $view = new NominatorView();
        //we need this so we can see the id later
        $view->setNominationId($this->id);
        $name = $this->getNominatorFullName();
        $link = $view->getLink($name);
        return $link;
    }




    // Row tags for DBPager
    public function rowTags() {

        //get nominee link
        //get nominee email

        $tpl             = array();
        $tpl['NOMINEE_LINK']     = $this->getNomineeLink();
        $tpl['NOMINATOR_LINK']   = $this->getNominatorLink();
        return $tpl;
    }
}


/**
 * This function is used by DB_Pager's csv reporting function. It returns
 * the row data for a CSV report of Nominations.
 *
 * This is located here instead of in the Nomination class because it needs to
 * be a standalone function, otherwise DB_Pager will not send it the Object it needs.
 *
 * @param obj An object representing a row of the CSV report.
 * @returns An associative array of variables that make up one row of a CSV report.
 */
function reportRowForCSV($obj) {
    $factory = new NominationFactory();
    $data = $factory->getNominationbyId($obj->getId());

    $row = array();

    $row['banner_id']               = $data->getBannerId();
    $row['first_name']              = $data->getFirstName();
    $row['middle_name']             = $data->getMiddleName();
    $row['last_name']               = $data->getLastName();
    $row['email']                   = $data->getEmail() . '@appstate.edu';
    $row['phone']                   = $data->getPhone();
    $row['asubox']                  = $data->getAsuBox();
    $row['position']                = $data->getPosition();
    $row['department_major']        = $data->getDeptMajor();
    $row['years_at_asu']            = $data->getYearsAtASU();
    $row['gpa']                     = $data->getGpa();
    $row['class']                   = $data->getClass();
    $row['responsibility']          = $data->getResponsibility();
    $row['nominator_first_name']    = $data->getNominatorFirstName();
    $row['nominator_middle_name']   = $data->getNominatorMiddleName();
    $row['nominator_last_name']     = $data->getNominatorLastName();
    $row['nominator_email']         = $data->getNominatorEmail() . '@appstate.edu';
    $row['nominator_phone']         = $data->getNominatorPhone();
    $row['nominator_address']       = $data->getNominatorAddress();
    $row['nominator_relation']      = $data->getNominatorRelation();

    // These variables are private in the nomination object.
    // To make these work, DB_Pager needs to pass the row data to this method so
    // that this method can load the nomination object from the DB.
    // DB_Pager only passes row data to standalone functions.
    $row['category']                = $data->getCategory();
    $row['period']                  = $data->getPeriod();
    $row['complete']                = $data->getComplete() ? 'Yes' : 'No';
    $row['winner']                  = $data->isWinner() ? 'Yes' : 'No';
    $row['added_on']                = strftime('%m/%d/%Y %T', $data->getAddedOn());
    $row['updated_on']              = strftime('%m/%d/%Y %T', $data->getUpdatedOn());

    $numRefs = \PHPWS_Settings::get('nomination', 'num_references_req');
    $db = new \PHPWS_DB('nomination_reference');
    $db->addWhere('nomination_id', $obj->getId());
    $references = $db->select();

    for($i = 0; $i < $numRefs; $i++) {
        $num = $i+1;
        $row['reference_'.$num.'_first_name'] = $references[$i]['first_name'];
        $row['reference_'.$num.'_last_name'] = $references[$i]['last_name'];
        $row['reference_'.$num.'_email'] = $references[$i]['email'];
        $row['reference_'.$num.'_phone'] = $references[$i]['phone'];
        $row['reference_'.$num.'_department'] = $references[$i]['department'];
        $row['reference_'.$num.'_relationship'] = $references[$i]['relationship'];
    }

    return $row;
}
