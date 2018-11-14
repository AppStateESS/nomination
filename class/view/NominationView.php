<?php

namespace nomination\view;

use \nomination\View;
use \nomination\Context;
use \nomination\Nominee;
use \nomination\Nominator;
use \nomination\Nomination;
use \nomination\NominationDocument;
use \nomination\ReferenceFactory;
use \nomination\DocumentFactory;
use \nomination\NominationFactory;

\PHPWS_Core::initModClass('filecabinet', 'Cabinet.php');

/**
 * NominationView
 *
 * Shows details of nominations.
 * This is plugged inside on the NomineeView
 *
 * @author Robert Bost <bostrt at tux dot appstate dot edu>
 */
class NominationView extends \nomination\View
{

    public $nominationId;

    public function getRequestVars()
    {
        $vars = array('id' => $this->nominationId,
            'view' => 'NominationView');

        return $vars;
    }

    public function display(Context $context)
    {
        $tpl = array();
        $factory = new NominationFactory;
        $nomination = $factory::getNominationById($context['id']);

        $tpl['NOMINEE'] = $nomination->getNomineeLink();
        $tpl['NOMINATOR_ID'] = $nomination->id;
        $tpl['NOMINATOR'] = $nomination->getNominatorLink();
        $tpl['NOMINATOR_RELATION'] = ($nomination->getNominatorRelation() == null ? "No relation given" : $nomination->getNominatorRelation());

        $db = \phpws2\Database::getDB();
        $tbl = $db->addTable('nomination_document');
        $tbl->addFieldConditional('nomination_id', $context['id']);
        $tbl->addFieldConditional('description', 'statement');
        $nominatorDocId = $db->selectColumn();

        if ($nominatorDocId == false) {
            return;
        }

        if (\PHPWS_Error::logIfError($nominatorDocId)) {
            throw new \nomination\exception\DatabaseException('Database is broken, please try again');
        }

        $doc = new DocumentFactory();
        $doc = $doc->getDocumentById($nominatorDocId);
        $tpl['NOMINATOR_STATEMENT'] = $doc->getDownloadLink($nomination->getUniqueId(),
                'Download Statement');

        $references = array();
        $db = \phpws2\Database::getDB();
        $tbl = $db->addTable('nomination_reference');
        $tbl->addFieldConditional('nomination_id', $nomination->id);
        $result = $db->select();

        // Fill the references array with references
        $numRefs = \PHPWS_Settings::get('nomination', 'num_references_req');
        for ($i = 0; $i < $numRefs; $i++) {
            $ref = new ReferenceFactory();
            $reference = $ref->getByUniqueId($result[$i]['unique_id']);
            $references[] = $reference;
        }

        $tpl['CATEGORY'] = $nomination->getCategory();
        $tpl['ADDED_ON'] = $nomination->getReadableAddedOn();
        $tpl['UPDATED_ON'] = $nomination->getReadableUpdatedOn();

        // Fill the repeating reference slots with data from the references array
        for ($i = 0; $i < $numRefs; $i++) {
            $refArray = array();
            $refArray['REFERENCE_NUMBER'] = "Reference " . ($i + 1);
            $refArray['REFERENCE_ID'] = $references[$i]->getId();
            $refArray['REFERENCE_NAME'] = $references[$i]->getFullName();
            $refArray['REFERENCE_RELATION'] = $references[$i]->getRelationship();

            if (is_null($references[$i]->getDocId())) {
                $refArray['REFERENCE_DOWNLOAD'] = 'No file uploaded';
            } else {
                $uniqueId = $references[$i]->getUniqueId();
                $referenceId = $references[$i]->getId();
                $refArray['REFERENCE_DOWNLOAD'] = <<<EOF
<a href="index.php?module=nomination&amp;view=DownloadFile&amp;unique_id={$uniqueId}&amp;reference=$referenceId">Download Reference</a>
EOF;
            }

            $tpl['references'][] = $refArray;
        }

        $tpl['COMPLETED'] = $nomination->getComplete() != 0 ? 'Complete' : 'Incomplete';

        javascript('jquery');
        javascriptMod('nomination', 'details',
                array('PHPWS_SOURCE_HTTP' => PHPWS_SOURCE_HTTP));

        if (isset($context['ajax'])) {
            echo \PHPWS_Template::processTemplate($tpl, 'nomination',
                    'admin/nomination.tpl');
            exit();
        } else {
            return \PHPWS_Template::processTemplate($tpl, 'nomination',
                            'admin/nomination.tpl');
        }
    }

}
