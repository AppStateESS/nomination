<?php
namespace nomination;
use \nomination\view\NotificationView;

class GuestNomination extends NominationMod
{
    /**
     * The default view for guests is going to be
     * the nomination form.  A guest is most likely
     * going to be submitting a form.
     */
    protected $defaultView = 'NominationForm';

    public function process()
    {
        try{
            parent::process();
        }catch(\nomination\exception\PermissionException $e){
            \PHPWS_Core::reroute('http:' . PHPWS_SOURCE_HTTP . 'index.php?module=nomination');
        }

        $vFactory = new ViewFactory();
        $view = $vFactory->get('UserView');
        $view->setMain($this->content);

        \Layout::add($view->display($this->context));
    }
}
