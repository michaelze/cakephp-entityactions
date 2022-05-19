<?php

namespace EntityActions\Exception;

use Cake\Core\Exception\Exception;

class UnknownEntityActionException extends Exception
{
    public function __construct(string $entityClass, string $entityActionClass)
    {
        parent::__construct(sprintf('Entity Action "%s" not registered for entity class "%s".', $entityActionClass, $entityClass));
    }
}
