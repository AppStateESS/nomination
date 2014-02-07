<?php
  /**
   * NominationView
   *
   * Shows details of nominations.
   * This is plugged inside on the NomineeView
   *
   * @author Robert Bost <bostrt at tux dot appstate dot edu>
   */

PHPWS_Core::initModClass('nomination', 'View.php');
PHPWS_Core::initModClass('nomination', 'Context.php');
PHPWS_Core::initModClass('nomination', 'Nominee.php');
PHPWS_Core::initModClass('nomination', 'Nominator.php');
PHPWS_Core::initModClass('nomination', 'Nomination.php');
PHPWS_Core::initModClass('nomination', 'NominationDocument.php');
PHPWS_Core::initModClass('nomination', 'ReferenceFactory.php');
PHPWS_Core::initModClass('nomination', 'DocumentFactory.php');
PHPWS_Core::initModClass('filecabinet', 'Cabinet.php');

class NominationView extends OmNomView {
    public $nominationId;

    public function getRequestVars(){
        $vars = array('id'   => $this->nominationId,
                      'view' => 'NominationView');

        return $vars;
    }


    public function display(Context $context){
	    PHPWS_Core::initModClass('nomination', 'NominationFactory.php');

        $tpl = array();
	    $factory = new NominationFactory;
	    $nomination = $factory::getNominationById($context['id']);

        $tpl['NOMINEE'] = $nomination->getNomineeLink();
        $tpl['NOMINATOR'] = $nomination->getNominatorLink();
        $tpl['NOMINATOR_RELATION'] = ($nomination->getNominatorRelation() == null ? "No relation given" : $nomination->getNominatorRelation());

        // Get the download link for the nominator statement
        $db = new PHPWS_DB('nomination_document');
        $db->addColumn('id');
        $db->addWhere('nomination_id', $context['id']);
        $db->addWhere('description', 'statement');
        $nominatorDocId = $db->select('row');
        
        if(PHPWS_Error::logIfError($nominatorDocId)) {
            throw new DatabaseException('Database is broken, please try again');
    	}
        
        $doc = new DocumentFactory();
        $doc = $doc->getDocumentById($nominatorDocId);
        $tpl['NOMINATOR_STATEMENT'] = $doc->getDownloadLink($nominatorDocId, 'Download Statement');

        // Get the references from the DB
	    $references = array();
        $db->reset();   // we recycle 'round here
        $db->setTable('nomination_reference');
    	$db->addWhere('nomination_id', $nomination->id);
        $result = $db->select();
	    
        if(PHPWS_Error::logIfError($result) || sizeof($result) == 0){
            throw new DatabaseException('Database is broken, please try again');
    	}
	    
        // Fill the references array with references
        $numRefs = PHPWS_Settings::get('nomination', 'num_references_req');
    	for($i = 0; $i < $numRefs; $i++){
	        $ref = new ReferenceFactory();
	        $reference = $ref->getByUniqueId($result[$i]['unique_id']);
    	    $references[] = $reference;
    	}

        $tpl['CATEGORY'] = $nomination->getCategory();
        $tpl['ADDED_ON'] = $nomination->getReadableAddedOn();
        $tpl['UPDATED_ON'] = $nomination->getReadableUpdatedOn();

        // Fill the repeating reference slots with data from the references array
        for($i = 0; $i < $numRefs; $i++){
            $refArray = array();
            $refArray['REFERENCE_NUMBER'] = "Reference " . ($i+1);
	        $refArray['REFERENCE_ID'] = $references[$i]->getId();
    	    $refArray['REFERENCE_NAME'] = $references[$i]->getFullName();
    	    $refArray['REFERENCE_RELATION'] = $references[$i]->getRelationship();
    	    
            if(is_null($references[$i]->getDocId())) {
    	        $refArray['REFERENCE_DOWNLOAD'] = 'No file uploaded';
            } else {
                $doc = new DocumentFactory();
                $doc = $doc->getDocumentById($references[$i]->getDocId());
                $refArray['REFERENCE_DOWNLOAD'] = $doc->getDownloadLink($references[$i]->getDocId(), 'Download Statement');
            }
            
            $tpl['references'][] = $refArray;
        }

        $tpl['COMPLETED'] = $nomination->getComplete() != 0 ? 'Complete' : 'Incomplete';

        javascript('jquery');
        javascriptMod('nomination', 'details', array('PHPWS_SOURCE_HTTP' => PHPWS_SOURCE_HTTP));

        if(isset($context['ajax'])){
            echo PHPWS_Template::processTemplate($tpl, 'nomination', 'admin/nomination.tpl');
            exit();
        } else {
            return PHPWS_Template::processTemplate($tpl, 'nomination', 'admin/nomination.tpl');
        }
    }
}
?>
