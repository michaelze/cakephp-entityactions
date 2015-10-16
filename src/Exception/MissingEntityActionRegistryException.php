<?php
namespace EntityActions\Exception;

use Cake\Core\Exception\Exception;

/**
 * This exception is thrown when the EntityActionManager is accessed without a entity action registry having been set beforehand.
 */
class MissingEntityActionRegistryException extends Exception {
}