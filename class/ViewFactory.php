<?php
namespace nomination;

  /**
   * ViewFactory.php
   *
   * ViewFactory stores path to Views directory and contains
   * throws proper exceptions when stuff goes wrong.
   *
   * @author Robert Bost <bostrt at tux dot appstate dot edu>
   */

class ViewFactory extends AbstractFactory
{
    private $dir = 'view';

    public function get($className)
    {
        if(is_null($className) || $className == ''){
            //$name = 'Null';
            throw new \InvalidArgumentException('Missing view name.');
        }

        $className = '\nomination\view\\' . $className;

        $instance = new $className();
        return $instance;
    }

    // inherited from parent
    public function getDirectory()
    {
        return $this->dir;
    }

    // inherited from parent
    public function throwIllegal($name)
    {
        throw new exception\IllegalViewException("Illegal characters found in view {$name}");
    }

    // inherited from parent
    public function throwNotFound($name)
    {
        throw new exception\ViewNotFoundException("Could not initialize view {$name}");
    }
}
