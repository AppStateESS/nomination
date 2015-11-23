<?php
namespace nomination;

  /**
   * CommandFactory.php
   *
   * CommandFactory stores path to Commands directory and contains
   * throws proper exceptions when stuff goes wrong.
   *
   * @author Robert Bost <bostrt at tux dot appstate dot edu>
   */
class CommandFactory
{
    public static function get($className)
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
