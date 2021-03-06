<?php
namespace nomination;

/**
* View
*
*   A class for seeing things.
*
* @author Daniel West <dwest at tux dot appstate dot edu>
* @package nomination
*/

abstract class View {
    public abstract function getRequestVars();
    public abstract function display(\nomination\Context $context);

    public function initForm(\PHPWS_Form $form)
    {
        $module = $form->get('module');
        if(\PEAR::isError($module)){
            $form->addHidden('module', 'nomination');
        }

        foreach($this->getRequestVars() as $key=>$value){
            $form->addHidden($key, $value);
        }
        $form->setMethod('get');
    }

    /**
    * Returns a properly formatted link to this command that can be
    * outputted straight to the browser.  If you want just the URL
    * instead of a properly formatted HTML link, have a look at
    * {@link getURI} instead.
    *
    * Make sure that if you're going to set any member variables, you
    * do it before running getLink, as it calls {@link getRequestVars}
    * and sets what variables are available at call time.
    *
    * @param string $text The text to format as a link
    * @param string $target The target of the link - See PHPWS_Text class.
    * @param string $cssClass The "class" (css) of the link.
    * @param string $title The alt-text for the link.
    * @return string The formatted link
    * @see getRequestVars
    * @see getURI
    * @see initForm
    * @see redirect
    * @see PHPWS_Text
    */
    public function getLink($text, $target = NULL, $cssClass = NULL, $title = NULL)
    {
        return \PHPWS_Text::moduleLink(dgettext('nomination', $text), 'nomination', $this->getRequestVars(), $target, $title, $cssClass);
    }

    /**
    * Returns the absolute URI to this command.  If you want to create
    * a proper HTML link to this command, you may want to look at
    * {@link getLink} instead.
    *
    * Make sure that if you're going to set any member variables, you
    * do it before running getURI, as it calls {@link getRequestVars}
    * and sets what variables are available at call time.
    *
    * @return string The absolute URI to this command
    * @see getRequestVars
    * @see getLink
    * @see initForm
    * @see redirect
    */
    public function getURI(){
        $uri = $_SERVER['SCRIPT_NAME'] . "?module=nomination";
        $uri = 'index.php?module=nomination';
        foreach($this->getRequestVars() as $key=>$val) {
            if(is_array($val)){
                foreach($val as $key2=>$val2)
                $uri .= "&$key" . "[$key2]=$val2";
            }else{
                $uri .= "&$key=$val";
            }
        }
        return $uri;
    }

    public function redirect(){
        \NQ::close();
        header("Location: ".$this->getURI());
        exit();
    }
}
