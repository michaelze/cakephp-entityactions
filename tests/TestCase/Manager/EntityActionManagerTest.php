<?php
namespace EntityActions\Test\Manager;

use Cake\ORM\Entity;
use Cake\TestSuite\TestCase;

use EntityActions\Manager\EntityActionManager;

use TestApp\EntityAction\TestEntityActionRegistry;

/**
 * Unit tests for the EntityActionManager class.
 */
class EntityActionManagerTest extends TestCase {

    public function testSetRegistryByString() {
        EntityActionManager::registry(TestEntityActionRegistry::class);
        $this->assertNotEmpty(EntityActionManager::get(Entity::class));
    }

    public function testSetRegistryObject() {
        EntityActionManager::registry(new TestEntityActionRegistry());
        $this->assertNotEmpty(EntityActionManager::get(Entity::class));
    }

    /**
     * @expectedException EntityActions\Exception\MissingEntityActionRegistryException
     */
    public function testSettingInvalidRegistryByClassnameThrowsException() {
        EntityActionManager::registry('EntityActionRegistryDoesNotExist');
    }

    /**
     * @expectedException EntityActions\Exception\MissingEntityActionRegistryException
     */
    public function testSettingInvalidRegistryObjectThrowsException() {
        EntityActionManager::registry(new \stdClass());
    }

    public function testGetEntityActionsByEntityClassName() {
        EntityActionManager::registry(TestEntityActionRegistry::class);
        $this->assertCount(4, EntityActionManager::get(Entity::class));
    }

    public function testGetEntityActionsByEntityObject() {
        EntityActionManager::registry(TestEntityActionRegistry::class);
        $this->assertCount(4, EntityActionManager::get(new Entity()));
    }

    public function testGetNoEntityActions() {
        EntityActionManager::registry(TestEntityActionRegistry::class);
        $this->assertCount(0, EntityActionManager::get('EntityThatDoesNotExist'));
    }

    /**
     * @expectedException EntityActions\Exception\NotAnEntityException
     */
    public function testGetThrowsExceptionForObjectNotBeingAnEntity() {
        EntityActionManager::registry(TestEntityActionRegistry::class);
        EntityActionManager::get(new \stdClass());
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     * @expectedException EntityActions\Exception\MissingEntityActionRegistryException
     */
    public function testGetThrowsExceptionWhenRegistryIsNotSet() {
        EntityActionManager::get(Entity::class);
    }
}