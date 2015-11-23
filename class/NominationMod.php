<?php
namespace nomination;

use \nomination\view\NotificationView;

abstract class NominationMod
{
    /**
     * The default-default view.
     * If you user goes to index.php?module=nomination
     * the Null view will be shown. This is overridden
     * by AdminNomination, CommitteeNomination, and GuestNomination.
     * Any new userviews should probably override this too.
     */
    protected $defaultView = 'Null';

    protected $context;
    protected $content;

    public function process()
    {
        // check_overpost is a thing with forms. if it is set then
        // we are most likely trying to redirect the user back to
        // their form
        if(!empty($_GET) && !isset($_GET['check_overpost'])){
            $this->context = new Context($_GET);
        }
        // Execute a command and redirect to its after view
        else if(!empty($_POST)){
            $this->context = new Context($_POST);

            $cmdFactory = new CommandFactory();
            $cmd = $cmdFactory->get($this->context['action']);

            try {
                $cmd->execute($this->context);

                if(isset($this->context['after']) && $this->context['after'] instanceof View){
                    $uri = $this->context['after']->getURI();
                } else if (isset($this->context['after'])) {
                    $uri = 'index.php?module=nomination&view=' . $this->context['after'];
                } else {
                    $uri = 'index.php';
                }

                \NQ::close();
                header("Location: ".$after);
                exit();
            } catch (\Exception $e) {
                $this->context['view'] = isset($this->context['after']) ? $this->context['after'] : 'Null';
                \NQ::simple('nomination', NotificationView::NOMINATION_ERROR, $e->getMessage());
                \NQ::close();
            }
        }

        /* Show any notifications */
        $nv = new NotificationView();
        $nv->popNotifications();

        try{
            $this->context['nq'] = $nv->show();
        } catch (\InvalidArgumentException $e){
            NotificationView::immediateError($e->getMessage());
        }

        // If view is not set in context then show the default view
        $viewName = isset($this->context['view']) ? $this->context['view'] : $this->defaultView;

        // Get view from factory and show it
        $view = ViewFactory::get($viewName);
        $this->content = $view->display($this->context);
    }
}
