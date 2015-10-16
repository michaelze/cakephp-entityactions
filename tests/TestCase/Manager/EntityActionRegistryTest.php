<?php
namespace EntityActions\Test\Manager;

use Cake\Collection\Collection;
use Cake\ORM\Entity;
use Cake\TestSuite\TestCase;

use TestApp\EntityAction\TestEntityActionRegistry;

/**
 * Unit tests for the EntityActionRegistry class.
 */
class EntityActionRegistryTest extends TestCase {

    public function testGetWithEntityClassName() {
        $entityActionRegistry = new TestEntityActionRegistry();
        $entityActionRegistry->getEntityActions(Entity::class);
    }

    public function testGetWithEntityObject() {
        $entityActionRegistry = new TestEntityActionRegistry();
        $entityActionRegistry->getEntityActions(new Entity());
    }

    public function testGetReturnsEmptyCollectionWithInvalidClassName() {
        $entityActionRegistry = new TestEntityActionRegistry();
        $entityActions = $entityActionRegistry->getEntityActions('EntityClassThatDoesNotExist');
        $this->assertCount(0, $entityActions);
        $this->assertInstanceOf(Collection::class, $entityActions);
    }

    /**
     * @expectedException EntityActions\Exception\NotAnEntityException
     */
    public function testGetThrowsExceptionWhenProvidedObjectIsNotAnEntity() {
        $entityActionRegistry = new TestEntityActionRegistry();
        $entityActionRegistry->getEntityActions(new \stdClass());
    }
}