<?php
namespace EntityActions\Manager;

use Cake\Collection\Collection;

use EntityActions\Exception\NotAnEntityException;

/**
 * Base class for entity action registries. It is meant to be subclassed in the application using the entity actions plugin. The subclass must
 * implement the abstract initialize() method in order to provide the registered entity actions.
 */
abstract class EntityActionRegistry implements IEntityActionRegistry {

    private $initialized;
    private $entityActions;

    public function getEntityActions($entityClass) {
        if (is_a($entityClass, 'Cake\ORM\Entity')) {
            $entityClass = get_class($entityClass);
        }
        if (!is_string($entityClass)) {
            throw new NotAnEntityException(sprintf('"%s" is not an entity.', json_encode($entityClass)));
        }
        $this->lazyInitialize();
        if (array_key_exists($entityClass, $this->entityActions)) {
            return $this->entityActions[$entityClass];
        }
        return new Collection([]);
    }

    /**
     * Subclasses must implement this method in order to provide the appliation's entity actions.
     * @return array Returns an array whose keys are fully qualified class names of entity classes. Their respective values are collections of entity
     *               action objects for each entity class name.
     */
    protected abstract function initialize();

    private function lazyInitialize() {
        if (!$this->initialized) {
            $this->entityActions = $this->initialize();
        }
    }

}