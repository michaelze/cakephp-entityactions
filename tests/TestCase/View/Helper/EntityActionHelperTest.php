<?php
namespace EntityActions\Test\View\Helper;

use Cake\ORM\Entity;
use Cake\Routing\Router;
use Cake\TestSuite\TestCase;
use Cake\View\View;

use EntityActions\Manager\EntityActionManager;
use EntityActions\View\Helper\EntityActionHelper;

use TestApp\EntityAction\TestEntityActionRegistry;
use TestApp\Model\Entity\EntityWithoutActions;

/**
 * Unit tests for the EntityActionHelper class.
 */
class EntityActionHelperTest extends TestCase {

    /**
     * @var EntityActionHelper
     */
    private static $entityActionHelper;

    public static function setUpBeforeClass() {
        parent::setUpBeforeClass();
        EntityActionManager::registry(TestEntityActionRegistry::class);
    }

    public function setUp() {
        parent::setUp();
        Router::connect('/test/test', ['controller' => 'Test', 'action' => 'test']);
        Router::connect('/test/test1', ['controller' => 'Test', 'action' => 'test1']);
        Router::connect('/test/test2', ['controller' => 'Test', 'action' => 'test2']);
        Router::connect('/test/test3', ['controller' => 'Test', 'action' => 'test3']);
        static::$entityActionHelper = new EntityActionHelper(new View());
    }

    public function testEntityActionsBeingRenderedForEntity() {
        $actions = static::$entityActionHelper->getActions(new Entity());
        $this->assertEquals('<ul class="entity-actions"><li class="entity-action class"><a href="/test/test">label</a></li><li class="entity-action class1"><a href="/test/test1">label1</a></li></ul>', $actions);
    }

    public function testEntityActionsBeingRenderedForEntityWithAdditionalDiv() {
        $actions = static::$entityActionHelper->getActions(new Entity(), ['div' => true]);
        $this->assertEquals('<div class="entity-actions"><ul class="entity-actions"><li class="entity-action class"><a href="/test/test">label</a></li><li class="entity-action class1"><a href="/test/test1">label1</a></li></ul></div>', $actions);
        $actions = static::$entityActionHelper->getActions(new Entity(), ['div' => 'add-class']);
        $this->assertEquals('<div class="entity-actions add-class"><ul class="entity-actions"><li class="entity-action class"><a href="/test/test">label</a></li><li class="entity-action class1"><a href="/test/test1">label1</a></li></ul></div>', $actions);
    }

    public function testUnAuthorizedEntityActionBeingRendered() {
        $actions = static::$entityActionHelper->getActions(new Entity(), ['notAuthorized' => true]);
        $this->assertEquals('<ul class="entity-actions"><li class="entity-action class"><a href="/test/test">label</a></li><li class="entity-action class1"><a href="/test/test1">label1</a></li><li class="entity-action class2 not-authorized"><a href="/test/test2">label2</a></li></ul>', $actions);
    }

    public function testDisabledEntityActionBeingRendered() {
        $actions = static::$entityActionHelper->getActions(new Entity(), ['disabled' => true]);
        $this->assertEquals('<ul class="entity-actions"><li class="entity-action class"><a href="/test/test">label</a></li><li class="entity-action class1"><a href="/test/test1">label1</a></li><li class="entity-action class3 disabled"><a href="/test/test3">label3</a></li></ul>', $actions);
    }

    public function testUnAuthorizedAndDisabledEntityActionBeingRendered() {
        $actions = static::$entityActionHelper->getActions(new Entity(), ['notAuthorized' => true, 'disabled' => true]);
        $this->assertEquals('<ul class="entity-actions"><li class="entity-action class"><a href="/test/test">label</a></li><li class="entity-action class1"><a href="/test/test1">label1</a></li><li class="entity-action class2 not-authorized"><a href="/test/test2">label2</a></li><li class="entity-action class3 disabled"><a href="/test/test3">label3</a></li></ul>', $actions);
    }

    public function testEmptyEntityActionCollectionBeingRendered() {
        $actions = static::$entityActionHelper->getActions(new EntityWithoutActions());
        $this->assertEquals('', $actions);
        $actions = static::$entityActionHelper->getActions(new EntityWithoutActions(), ['div' => true]);
        $this->assertEquals('<div class="entity-actions"></div>', $actions);
    }
}