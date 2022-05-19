<?php

namespace EntityActions\Exception;

use Cake\Http\Exception\BadRequestException;

/**
 * This exception is thrown, when an entity action is not enabled when checked inside a controller method.
 */
class ActionNotEnabledException extends BadRequestException
{
    public function __construct()
    {
        parent::__construct(__('Diese Aktion ist zur Zeit nicht verfügbar.'));
    }
}
