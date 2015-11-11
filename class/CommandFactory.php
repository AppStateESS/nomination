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
class CommandFactory extends AbstractFactory
{
    private $dir = 'command';

    // inherited from parent
    public function getDirectory()
    {
        return $this->dir;
    }

    // inherited from parent
    public function throwIllegal($name)
    {
        throw new exception\IllegalCommandException("Illegal characters found in command {$name}");
    }

    // inherited from parent
    public function throwNotFound($name)
    {
        throw new exception\CommandNotFoundException("Could not initialize command {$name}");
    }
}
