<?php
namespace EntityActions\Test\EntityAction;

use Cake\ORM\Entity;
use Cake\TestSuite\TestCase;

use EntityActions\EntityAction\EntityAction;

/**
 * Unit Tests for the EntityAction class.
 */
class EntityActionTest extends TestCase {

    public function testDefaultValuesAreUsedInConstructor() {
        $entityAction = new EntityAction('label', 'class', function ($e) {
            return ['controller' => 'Test', 'action' => 'test'];
        });
        $this->assertEquals('label', $entityAction->getLabel());
        $this->assertEquals('class', $entityAction->getClass());
        $this->assertEquals(['controller' => 'Test', 'action' => 'test'], $entityAction->getUrl(new Entity()));
        $this->assertTrue($entityAction->isAuthorized(new Entity(), 'someUserId'));
        $this->assertTrue($entityAction->isEnabled(new Entity()));
    }

    public function testSpecialAuthorizedCallable() {
        $entityAction = new EntityAction('label', 'class', function ($e) {
            return ['controller' => 'Test', 'action' => 'test'];
        }, function ($url, $entity, $userId) {
            if ($userId == 'authorized') {
                return true;
            } else {
                return false;
            }
        });
        $this->assertTrue($entityAction->isAuthorized(new Entity(), 'authorized'));
        $this->assertFalse($entityAction->isAuthorized(new Entity(), 'unauthorized'));
    }

    public function testSpecialEnabledCallable() {
        $entityAction = new EntityAction('label', 'class', function ($e) {
            return ['controller' => 'Test', 'action' => 'test'];
        }, null, function (Entity $entity) {
            if ($entity->get('property') == 'enabled') {
                return true;
            } else {
                return false;
            }
        });
        $entity = new Entity();
        $entity->set('property', 'enabled');
        $this->assertTrue($entityAction->isEnabled($entity));
        $entity->set('property', 'disabled');
        $this->assertFalse($entityAction->isEnabled($entity));
    }
}