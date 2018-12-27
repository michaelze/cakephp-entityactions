<?php
namespace EntityActions\Test\Manager;

use Cake\ORM\Entity;
use Cake\TestSuite\TestCase;

use TestApp\EntityAction\TestEntityActionRegistry;

/**
 * Unit tests for the EntityActionRegistry class.
 */
class EntityActionRegistryTest extends TestCase {

    public function testGetWithEntityClassName() {
        $entityActionRegistry = new TestEntityActionRegistry();
        $entityActions = $entityActionRegistry->getEntityActions('Cake\ORM\Entity');
        $this->assertCount(4, $entityActions);
    }

    public function testGetWithEntityObject() {
        $entityActionRegistry = new TestEntityActionRegistry();
        $entityActions = $entityActionRegistry->getEntityActions(new Entity());
        $this->assertCount(4, $entityActions);
    }

    public function testGetReturnsEmptyCollectionWithInvalidClassName() {
        $entityActionRegistry = new TestEntityActionRegistry();
        $entityActions = $entityActionRegistry->getEntityActions('EntityClassThatDoesNotExist');
        $this->assertCount(0, $entityActions);
        $this->assertInstanceOf('Cake\Collection\Collection', $entityActions);
    }

    /**
     * @expectedException EntityActions\Exception\NotAnEntityException
     */
    public function testGetThrowsExceptionWhenProvidedObjectIsNotAnEntity() {
        $entityActionRegistry = new TestEntityActionRegistry();
        $entityActionRegistry->getEntityActions(new \stdClass());
    }
}