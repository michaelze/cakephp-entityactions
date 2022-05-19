<?php

namespace EntityActions\Model\Behavior;

use Cake\Collection\Collection;
use Cake\ORM\Behavior;
use Cake\ORM\Query;
use EntityActions\EntityAction\IEntityAction;
use EntityActions\Exception\UnknownEntityActionException;
use EntityActions\Manager\EntityActionManager;

/**
 * Behavior for common entity action table logic.
 */
class EntityActionBehavior extends Behavior
{
    /**
     * This finder adds associations to the provided query based on the entity actions associated with the entity class belonging to the table.
     *
     * @param Cake\ORM\Query $query The query to adapt.
     * @param array $options
     *   `entityAction`: Allows to restrict the entity actions considered to a specific one instead of all the entity actions of the respective
     *                   entity.
     * @return Cake\ORM\Query Returns the modified query.
     */
    public function findEntityActions(Query $query, array $options)
    {
        $table = $this->getTable();
        $entityClass = $table->getEntityClass();
        if (isset($options['entityAction'])) {
            $entityActionClass = $options['entityAction'];
            $entityAction = EntityActionManager::getEntityAction($entityClass, $entityActionClass);
            if (!$entityAction) {
                throw new UnknownEntityActionException($entityClass, $entityActionClass);
            }
            $entityActions = new Collection([$entityAction]);
        } else {
            $entityActions = EntityActionManager::get($entityClass);
        }

        $associations = $entityActions
            ->map(function (IEntityAction $entityAction) {
                return $entityAction->getAssociations();
            })
            ->reduce(function ($accumulated, $associations) {
                return $accumulated + $associations;
            }, []);

        if (!empty($associations)) {
            $query->contain($associations);
        }

        return $query;
    }
}
