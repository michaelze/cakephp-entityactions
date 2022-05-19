<?php

namespace EntityActions\Controller\Component;

use Cake\Controller\Component;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Query;
use EntityActions\Exception\ActionNotEnabledException;
use EntityActions\Manager\EntityActionManager;

/**
 * Component for common entity action controler logic.
 */
class EntityActionComponent extends Component
{
    /**
     * Checks whether the provided entity action is enabled for the entity returned by the provided query.
     * This method calls Query::firstOrFail() on the provided query to retrieve the entity in question.
     * @param Cake\ORM\Query $entityQuery The query to use to retrieve the entity.
     * @param string $entityActionClass The IEntityAction class to check for enabled.
     * @return Cake\Datasource\EntityInterface Returns the retrieved entity.
     * @throws ActionNotEnabledException This exception is thrown in case the entity action is not enabled for the retrieved entity.
     */
    function checkEnabledOrThrow(Query $entityQuery, string $entityActionClass): EntityInterface
    {
        $entity = $entityQuery->find('entityActions', ['entityAction' => $entityActionClass])->firstOrFail();
        $entityAction = EntityActionManager::getEntityAction($entity, $entityActionClass);
        if ($entityAction->isEnabled($entity)) {
            return $entity;
        }
        throw new ActionNotEnabledException();
    }
}
