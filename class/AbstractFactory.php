<?php
namespace nomination;

  /**
   * AbstractFactory.php
   *
   * @author Robert Bost <bostrt at tux dot appstate dot edu>
   */

abstract class AbstractFactory
{
    public abstract function getDirectory();
    public abstract function throwIllegal($name);
    public abstract function throwNotFound($name);

    public function get($className)
    {
        if(is_null($className) || $className == ''){
            //$name = 'Null';
            throw new \InvalidArgumentException('Missing view name.');
        }

        $className = '\nomination\command\\' . $className;

        $instance = new $className();
        return $instance;
    }
}
