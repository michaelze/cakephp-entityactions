<?php
namespace EntityActions\Manager;

use Cake\Collection\Collection;

use EntityActions\Exception\NotAnEntityException;

/**
 * Defines the interface for entity action registries.
 */
interface IEntityActionRegistry {

    /**
     * Returns all the entity action objects for the provided entity class from the registry.
     * @param mixed $entityClass
     *          This may be either the entity object or the name of the entity class you wish to retrieve the entity actions for.
     * @return Collection Returns a collection containing all the entity actions associated with the provided entity class name/object.
     * @throws NotAnEntityException
     *          This exception is thrown when the provided argument is neither an entity object nor the name of an entity class.
     */
    public function getEntityActions($entityClass);

}