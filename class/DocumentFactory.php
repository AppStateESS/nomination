<?php
namespace nomination;

/**
 * DocumentFactory
 *
 * Class for loading and saving NominationDocument objects from the database.
 *
 * @author jbooker
 * @package nomination
 */

class DocumentFactory {

    /**
     * Returns a NominationDocument object loaded from the DB using the nomination's doc_id,
     * or returns null if that id does not exist in the DB.
     *
     * @param $id Nomination's doc_id
     * @return NominationDocument The corresponding NominationDocument object, or null if the id doesn't exist.
     */
    public static function getDocumentById($id) {
        if (!isset($id)) {
            throw new \InvalidArgumentException('Missing ID.');
        }

        $db = new \PHPWS_DB('nomination_document');
        $db->addWhere('id', $id);
        $result = $db->select('row');

        if (\PHPWS_Error::logIfError($result)) {
            \PHPWS_Core::initModClass('nomination', 'exception/DatabaseException.php');
            throw new exception\DatabaseException($result->toString('No document found in DB.'));
        }

        if (count($result) == 0) {
            return null;
        }

        $doc = new DBNominationDocument();
        $doc->setId($id);
        $doc->setNominationById($result['nomination_id']);
        $doc->setUploadedBy($result['uploaded_by']);
        $doc->setDescription($result['description']);
        $doc->setFilePath($result['file_path']);
        $doc->setFileName($result['file_name']);
        $doc->setOrigFileName($result['orig_file_name']);
        $doc->setMimeType($result['mime_type']);

        return $doc;
    }
    
    public static function getNominatorDocument($nominationId)
    {
        $db = \phpws2\Database::getDB();
        $tbl = $db->addTable('nomination_document');
        $tbl->addFieldConditional('nomination_id', $nominationId);
        $tbl->addFieldConditional('uploaded_by', 'nominator');
        $result = $db->selectOneRow();
        if (empty($result)) {
            return null;
        }
        extract($result);
        $doc = new DBNominationDocument();
        $doc->setId($id);
        $doc->setNominationById($result['nomination_id']);
        $doc->setUploadedBy($result['uploaded_by']);
        $doc->setDescription($result['description']);
        $doc->setFilePath($result['file_path']);
        $doc->setFileName($result['file_name']);
        $doc->setOrigFileName($result['orig_file_name']);
        $doc->setMimeType($result['mime_type']);

        return $doc;
    }

    public static function getReferenceDocument($referenceId)
    {
        $db = \phpws2\Database::getDB();
        $tbl = $db->addTable('nomination_document');
        $tbl->addFieldConditional('uploaded_by', 'reference');
        $tbl2 = $db->addTable('nomination_reference');
        $tbl2->addFieldConditional('id', $referenceId);
        $cond = $db->createConditional($tbl->getField('id'), $tbl2->getField('doc_id'));
        $db->joinResources($tbl, $tbl2, $cond);
        $result = $db->selectOneRow();
        if (empty($result)) {
            return null;
        }
        extract($result);
        $doc = new DBNominationDocument();
        $doc->setId($id);
        $doc->setNominationById($result['nomination_id']);
        $doc->setUploadedBy($result['uploaded_by']);
        $doc->setDescription($result['description']);
        $doc->setFilePath($result['file_path']);
        $doc->setFileName($result['file_name']);
        $doc->setOrigFileName($result['orig_file_name']);
        $doc->setMimeType($result['mime_type']);

        return $doc;
    }
    
    public static function save(NominationDocument $doc)
    {
        $db = new \PHPWS_DB('nomination_document');

        $db->addValue('nomination_id', $doc->getNomination()->getId());
        $db->addValue('uploaded_by', $doc->getUploadedBy());
        $db->addValue('description', $doc->getDescription());
        $db->addValue('file_path', $doc->getFilePath());
        $db->addValue('file_name', $doc->getFileName());
        $db->addValue('orig_file_name', $doc->getOrigFileName());
        $db->addValue('mime_type', $doc->getMimeType());

        $id = $doc->getId();
        if(!isset($id) || is_null($id)) {
            $result = $db->insert();
            if(!\PHPWS_Error::isError($result)){
                // If everything worked, insert() will return the new database id,
                // So, we need to set that on the object for later
                $doc->setId($result);
            }
        }else{
            $db->addWhere('id', $id);
            $result = $db->update();
        }

        if(\PHPWS_Error::logIfError($result)){
            throw new \Exception('DatabaseException: Failed to save document. ' . $result->toString());
        }
    }

}
