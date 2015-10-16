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
        EntityActionManager::registry('TestEntityActionRegistry');
        $this->assertNotEmpty(EntityActionManager::get('Cake\ORM\Entity'));
    }

    public function testSetRegistryObject() {
        EntityActionManager::registry(new TestEntityActionRegistry());
        $this->assertNotEmpty(EntityActionManager::get('Cake\ORM\Entity'));
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
        EntityActionManager::registry('TestApp\EntityAction\TestEntityActionRegistry');
        $this->assertCount(4, EntityActionManager::get('Cake\ORM\Entity'));
    }

    public function testGetEntityActionsByEntityObject() {
        EntityActionManager::registry('TestApp\EntityAction\TestEntityActionRegistry');
        $this->assertCount(4, EntityActionManager::get(new Entity()));
    }

    public function testGetNoEntityActions() {
        EntityActionManager::registry('TestApp\EntityAction\TestEntityActionRegistry');
        $this->assertCount(0, EntityActionManager::get('EntityThatDoesNotExist'));
    }

    /**
     * @expectedException EntityActions\Exception\NotAnEntityException
     */
    public function testGetThrowsExceptionForObjectNotBeingAnEntity() {
        EntityActionManager::registry('TestApp\EntityAction\TestEntityActionRegistry');
        EntityActionManager::get(new \stdClass());
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     * @expectedException EntityActions\Exception\MissingEntityActionRegistryException
     */
    public function testGetThrowsExceptionWhenRegistryIsNotSet() {
        EntityActionManager::get('Cake\ORM\Entity');
    }
}