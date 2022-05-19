<?php
namespace EntityActions\EntityAction;

use Cake\Network\Request;
use Cake\ORM\Entity;

/**
 * Base implementation for the IEntityAction interface.
 */
class EntityAction implements IEntityAction {

    private $label;
    private $class;
    private $url;
    private $authorized;
    private $enabled;

    /**
     * Creates a new instance of the EntityActions class and initializes its properties.
     * @param string $label
     *          The label for the entity action.
     * @param string $class
     *          The class for the entity action.
     * @param callable $url
     *          A callable that returns the url in cake array notation for the entity action. The callable may accept one parameter of type Entity.
     *          When executed, the entity, this entity action should be output for, will be provided.
     * @param callable $authorized
     *          A callable that returns true, when the currently logged in user is authorized to execute the entity action, false otherwise. The
     *          provided callback may expect three parameters:
     *          1. The url for the entity action in cake array notation.
     *          2. The entity this entity action should be output for.
     *          3. The id of the user that is to check for authorization.
     *          The default implementation for this callable always returns true.
     * @param callable $enabled
     *          A callable that returns true, when the the entity action is enabled, false otherwise. The provided callback may expect the entity,
     *          this entity action should be output for, as a parameter.
     *
     */
    public function __construct($label, $class, callable $url, callable $authorized = null, callable $enabled = null) {
        $this->label = $label;
        $this->class = $class;
        $this->url = $url;
        if ($authorized == null) {
            $this->authorized = function ($url, $entity, $userId) {
                return true;
            };
        } else {
            $this->authorized = $authorized;
        }
        if ($enabled == null) {
            $this->enabled = function ($entity) {
                return true;
            };
        } else {
            $this->enabled = $enabled;
        }
    }

    public function getLabel() {
        return $this->label;
    }

    public function getClass() {
        return $this->class;
    }

    public function getUrl(Entity $entity) {
        $url = $this->url;
        return $url($entity);
    }

    public function isAuthorized(Entity $entity, $userId, Request $request) {
        $authorized = $this->authorized;
        return $authorized($this->getUrl($entity), $entity, $userId, $request);
    }

    public function isEnabled(Entity $entity) {
        $enabled = $this->enabled;
        return $enabled($entity);
    }

    /**
     * Returns associations that are required for authorized/enabled calculations for this entity action.
     * @return array An array or required associations.
     */
    public function getAssociations(): array
    {
        return [];
    }

    public function getViewHints() : array {
        return [];
    }
}