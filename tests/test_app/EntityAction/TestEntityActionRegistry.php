<?php
namespace TestApp\EntityAction;

use Cake\Collection\Collection;
use Cake\ORM\Entity;

use EntityActions\Manager\EntityActionRegistry;

use TestApp\EntityAction\Entity\TestEntityAction;
use EntityActions\EntityAction\EntityAction;

/**
 * Entity action registry implementation for unit tests.
 */
class TestEntityActionRegistry extends EntityActionRegistry {
    public function initialize() {
        return [
            Entity::class => new Collection([
                new TestEntityAction(),
                new EntityAction('label1', 'class1', function ($e) {
                    return ['controller' => 'Test', 'action' => 'test1'];
                }),
                new EntityAction('label2', 'class2', function ($e) {
                    return ['controller' => 'Test', 'action' => 'test2'];
                }, function ($url, $e, $userId) {
                    return false;
                }),
                new EntityAction('label3', 'class3', function ($e) {
                    return ['controller' => 'Test', 'action' => 'test3'];
                }, null, function ($e) {
                    return false;
                })
            ])
        ];
    }
}