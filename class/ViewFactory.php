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

class ViewFactory
{
    public static function get($className)
    {
        if(is_null($className) || $className == ''){
            //$name = 'Null';
            throw new \InvalidArgumentException('Missing view name.');
        }

        $className = '\nomination\view\\' . $className;

        $instance = new $className();
        return $instance;
    }
}
