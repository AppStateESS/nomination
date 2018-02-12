<?php
namespace nomination;

/**
 * ReferenceFactory
 *
 * Factory class for loading and saving Reference objects from the database.
 *
 * @author jbooker
 * @package nomination
 */
class ReferenceFactory {

    public static function save(Reference $ref)
    {
        $db = new \PHPWS_DB('nomination_reference');

        $db->addValue('nomination_id', $ref->getNominationId());
        $db->addValue('first_name', $ref->getFirstName());
        $db->addValue('last_name', $ref->getLastName());
        $db->addValue('email', $ref->getEmail());
        $db->addValue('phone', $ref->getPhone());
        $db->addValue('department', $ref->getDepartment());
        $db->addValue('relationship', $ref->getRelationship());
        $db->addValue('unique_id', $ref->getUniqueId());
        $db->addValue('doc_id', $ref->getDocId());

        $id = $ref->getId();
        if(!isset($id) || is_null($id)) {
            $result = $db->insert();
            if(!\PHPWS_Error::isError($result)){
                // If everything worked, insert() will return the new database id,
                // So, we need to set that on the object for later
                $ref->setId($result);
            }
        }else{
            $db->addWhere('id', $id);
            $result = $db->update();
        }

        if(\PHPWS_Error::logIfError($result)){
            throw new exception\Exception('DatabaseException: Failed to save reference. ' . $result->toString());
        }
    }

    /**
     * Returns the Reference object with the given uniqueId, or null if
     * no matching reference is found.
     *
     * @param string $uniqueId - The Reference's unique ID.
     * @return Reference Reference object, or null if no matching id found
     */
    public static function getByUniqueId($uniqueId){

        $db = new \PHPWS_DB('nomination_reference');

        $db->addWhere('unique_id', $uniqueId);

        $result = $db->select('row');

        if(\PHPWS_Error::logIfError($result)){
            \PHPWS_Core::initModClass('nomination', 'exception/DatabaseException.php');
            throw new exception\DatabaseException($result->toString());
        }

        if(count($result) == 0){
            return null;
        }

        $ref = new DBReference();
        $ref->setId($result['id']);
        $ref->setFirstName($result['first_name']);
        $ref->setLastName($result['last_name']);
        $ref->setDepartment($result['department']);
        $ref->setEmail($result['email']);
        $ref->setPhone($result['phone']);
        $ref->setUniqueId($result['unique_id']);
        $ref->setDocId($result['doc_id']);
        $ref->setRelationship($result['relationship']);
        $ref->setNominationId($result['nomination_id']);

        return $ref;
    }

    /**
     * Returns the Reference object with the given nomination id, or null if
     * no matching reference is found.
     *
     * @param string $Id - The Reference's nomination ID.
     * @return Reference Reference object, or null if no matching id found
     */
    public static function getByNominationId($Id){

        $db = new \PHPWS_DB('nomination_reference');

        $db->addWhere('nomination_id', $Id);

        $results = $db->select();

        if(\PHPWS_Error::logIfError($results)){
            \PHPWS_Core::initModClass('nomination', 'exception/DatabaseException.php');
            throw new exception\DatabaseException($results->toString());
        }


        $objs = array();

        foreach ($results as $result){
            $ref = new DBReference();
            $ref->setId($result['id']);
            $ref->setFirstName($result['first_name']);
            $ref->setLastName($result['last_name']);
            $ref->setDepartment($result['department']);
            $ref->setEmail($result['email']);
            $ref->setPhone($result['phone']);
            $ref->setUniqueId($result['unique_id']);
            $ref->setDocId($result['doc_id']);
            $ref->setRelationship($result['relationship']);
            $ref->setNominationId($result['nomination_id']);

            $objs[] = $ref;
        }

        return $objs;
    }

    /**
     * Returns the Reference object with the given nomination id, or null if
     * no matching reference is found.
     *
     * @param string $Id - The Reference's nomination ID.
     * @return nomination\Reference Reference object, or null if no matching id found
     */
    public static function getReferenceById($Id){

        $db = new \PHPWS_DB('nomination_reference');

        $db->addWhere('id', $Id);

        $results = $db->select();
        if(\PHPWS_Error::logIfError($results)){
            \PHPWS_Core::initModClass('nomination', 'exception/DatabaseException.php');
            throw new exception\DatabaseException($results->toString());
        }
        if (empty($results)) {
            $ref = new DBReference();
            $ref->setFirstName('Broken email - account deleted');
            return $ref;
        }
        $objs = array();

        foreach ($results as $result){
            $ref = new DBReference();
            $ref->setId($result['id']);
            $ref->setFirstName($result['first_name']);
            $ref->setLastName($result['last_name']);
            $ref->setDepartment($result['department']);
            $ref->setEmail($result['email']);
            $ref->setPhone($result['phone']);
            $ref->setUniqueId($result['unique_id']);
            $ref->setDocId($result['doc_id']);
            $ref->setRelationship($result['relationship']);
            $ref->setNominationId($result['nomination_id']);

            $objs[] = $ref;
        }

        return $objs[0];
    }

    /**
     * Delete nomination with the given id
     *
     * @param $id Nomination id
     */
    public static function deleteRefByNomId($id)
    {
      if(!isset($id))
      {
          throw new exception\InvalidArgumentException('Missing nomination id for deleteRefByNomId().');
      }

      $db = Reference::getDb();

      $db->addWhere('nomination_id', $id);
      $db->delete();
    }

}
