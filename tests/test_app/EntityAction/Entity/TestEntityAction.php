<?php
namespace TestApp\EntityAction\Entity;

use EntityActions\EntityAction\EntityAction;

/**
 * Entity action implementation for unit tests.
 */
class TestEntityAction extends EntityAction {

    public function __construct() {
        parent::__construct('label', 'class', function ($e) {
            return ['controller' => 'Test', 'action' => 'test'];
        });
    }

}