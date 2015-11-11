<?php
namespace nomination\view;

use \nomination\View;
use \nomination\Nominator;
use \nomination\UserStatus;

\PHPWS_Core::initCoreClass('DBPager.php');

class NominatorSearch extends \nomination\View
{
    public function getRequestVars()
    {
        return array('view'=>'NominatorSearch');
    }

    public function display(Context $context)
    {
        if(!UserStatus::isAdmin() && !UserStatus::isCommitteeMember()){
            throw new \nomination\exception\PermissionException('You are not allowed to look at that!');
        }

        $ajax = !is_null($context['ajax']);
        $searchString = !is_null($context['query']) ? $context['query'] : '';


        if($ajax){
            echo $this->getPager($searchString);
            exit;
        } else {

            javascript('jquery_ui');
            javascriptMod('nomination', 'search', array('PHPWS_SOURCE_HTTP' => PHPWS_SOURCE_HTTP));
            $form = new \PHPWS_Form('search');
            $form->setMethod('get');
            $form->addText('query', $searchString);
            $form->addCssClass('query', 'form-control');
            $form->addHidden('module', 'nomination');
            $form->addHidden('view', 'NominatorSearch');
            $form->addSubmit('Search');

            $tpl = $form->getTemplate();

            $tpl['PAGER'] = $this->getPager($searchString);
            $tpl['TITLE'] = 'Nominator Search';

            \Layout::addPageTitle('Nominator Search');


            return \PHPWS_Template::process($tpl, 'nomination', 'admin/search.tpl');
        }
    }

    public function getPager($searchString="")
    {
        \PHPWS_Core::initModClass('nomination', 'Period.php');
        \PHPWS_Core::initModClass('nomination', 'Nomination.php');

        $pager = new \DBPager('nomination_nomination', 'DBNomination');
        $pager->setModule('nomination');
        $pager->setTemplate('admin/nominator_search_results.tpl');
        $pager->setEmptyMessage('No matching nominators found');
        $pager->setReportRow('reportRowForCSV');

        $pager->db->addWhere('first_name', "%".$searchString."%", "like", 'or', 'search');
        $pager->db->addWhere('middle_name', "%".$searchString."%", "like", 'or', 'search');
        $pager->db->addWhere('last_name', "%".$searchString."%", "like", 'or', 'search');

        // New search fields
        $pager->db->addWhere('nominator_email', "%".$searchString."%", "like", 'or', 'search');
        $pager->db->addWhere('nominator_first_name', "%".$searchString."%", "like", 'or', 'search');
        $pager->db->addWhere('nominator_middle_name', "%".$searchString."%", "like", 'or', 'search');
        $pager->db->addWhere('nominator_last_name', "%".$searchString."%", "like", 'or', 'search');

        // Committee members should only see completed nominations.
        if(UserStatus::isCommitteeMember()){
            $pager->db->addWhere('nomination_nomination.complete', TRUE);
        }

        $pager->db->addJoin('left', 'nomination_nomination', 'nomination_period', 'period', 'id');
        $pager->db->addWhere('nomination_period.year', Period::getCurrentPeriodYear());

        $pager->addSortHeader('first_name', 'First');
        $pager->addSortHeader('middle_name', 'Middle');
        $pager->addSortHeader('last_name', 'Last');
        $pager->addRowTags('rowTags');
        
        return $pager->get();
    }
}
