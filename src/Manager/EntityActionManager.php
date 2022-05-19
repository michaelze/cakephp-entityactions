<?php
namespace EntityActions\Manager;

use Cake\Collection\Collection;
use Cake\Core\App;
use EntityActions\EntityAction\IEntityAction;
use EntityActions\Exception\MissingEntityActionRegistryException;
use EntityActions\Exception\NotAnEntityException;

/**
 * This class manages all entity actions registered in the application and provides a way of accessing them.
 */
class EntityActionManager {

    /**
     * The entity action registry implementation that registers the application's entity actions.
     * @var IEntityActionRegistry
     */
    private static $entityActionRegistry;

    /**
     * Call this method in order to register an entity action registry implementation with this EntityActionManager.
     * @param mixed $registry
     *          Either a string providing the name of a class implementing the IEntityActionRegistry interface, or an instance of a class
     *          implementing IEntityActionRegistry.
     * @throws MissingEntityActionRegistryException
     *          Thrown, if the provided registry neither is the name of a suitable class nor a suitable IEntityActionRegistry object.
     */
    public static function registry($registry) {
        if (is_string($registry)) {
            $className = App::className($registry, 'EntityAction');
            if (!$className) {
                throw new MissingEntityActionRegistryException(sprintf('Cannot locate entity action registry named "%s".', $registry));
            }
            static::$entityActionRegistry = new $className();
        } else if (is_a($registry, 'EntityActions\Manager\IEntityActionRegistry')) {
            static::$entityActionRegistry = $registry;
        } else {
            $registryString = is_object($registry) ? get_class($registry) : (string) $registry;
            throw new MissingEntityActionRegistryException(
                    sprintf('"%s" neither implements IEntityActionRegistry nor is it a valid entity action registry class name.', $registryString));
        }
    }

    /**
     * Returns all the entity action objects for the provided entity class.
     * @param mixed $entityClass
     *          This may be either the entity object or the name of the entity class you wish to retrieve the entity actions for.
     * @return Collection Returns a collection containing all the entity actions associated with the provided entity class name/object.
     * @throws MissingEntityActionRegistryException
     *          This exception is thrown when no entity action registry has been provided to the EntityActionManager prior to calling this method.
     * @throws NotAnEntityException
     *          This exception is thrown when the provided argument is neither an entity object nor the name of an entity class.
     */
    public static function get($entityClass): Collection
    {
        if (static::$entityActionRegistry == null) {
            throw new MissingEntityActionRegistryException('No entity action registry provided prior to accessing the entity action manager.');
        }
        return static::$entityActionRegistry->getEntityActions($entityClass);
    }

    public static function getEntityAction($entityClass, $entityActionClass): ?IEntityAction
    {
        $entityActions = static::get($entityClass);
        return $entityActions->filter(function ($entityAction) use ($entityActionClass) {
            return get_class($entityAction) == $entityActionClass;
        })->first();
    }
}
