<?php
namespace EntityActions\EntityAction;

use Cake\Network\Request;
use Cake\ORM\Entity;

/**
 * Interface for entity actions.
 */
interface IEntityAction {

    /**
     * Call this method to retrieve the entity action's label.
     * @return string Returns the label.
     */
    public function getLabel();

    /**
     * Call this method to retrieve the entity action's css class.
     * @return string Returns the css class.
     */
    public function getClass();

    /**
     * Call this method to retrieve the entity action's url.
     * @param Entity $entity
     *          The entity context that is used to construct the url for this entity action.
     * @return array Returns the url for this entity action in cakephp url array notation.
     */
    public function getUrl(Entity $entity);

    /**
     * Call this method in order to determine whether the user with the provided id is authorized to access this entity action.
     * @param Entity $entity
     *          The entity context that is used in order to determine whether the user with the provided id is authorized.
     * @param string $userId
     *          The id of the user to check for authorization.
     * @param Request $request
     *          The request currently handled by the application.
     * @return boolean Returns true, if the user is authorized, false otherwise.
     */
    public function isAuthorized(Entity $entity, $userId, Request $request);

    /**
     * Call this method in order to determine whether this action is currently enabled or not.
     * @param Entity $entity
     *          The entity context that is used in order to determine whether the entity action is enabled.
     * @return boolean Returns true, if this entity action is enabled, false otherwise.
     */
    public function isEnabled(Entity $entity);
}