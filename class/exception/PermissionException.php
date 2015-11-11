<?php
namespace nomination\exception;

/**
 * PermissionException
 *
 * This right here is a permission exception.
 *
 * @author Robert Bost <bostrt at tux dot appstate dot edu>
 */
class PermissionException extends NominationException
{
    public function __construct($message, $code = 0)
    {
        parent::__construct($message, $code);
    }
}
