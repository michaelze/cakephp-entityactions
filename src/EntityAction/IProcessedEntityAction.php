<?php
namespace EntityActions\EntityAction;

/**
 * Defines the interface for processed entity actions.
 */
interface IProcessedEntityAction {

    /**
     * Returns the entity action's label.
     */
    public function getLabel() : string;

    /**
     * Returns the entity action's css class.
     */
    public function getClass() : string;

    /**
     * Returns the entity action's url for the entity it was processed with.
     */
    public function getUrl() : array;

    /**
     * Returns true, if the current user is authorized to use this entity action, false otherwise.
     */
    public function isAuthorized() : bool;

    /**
     * Returns true, if the entity action is currently enabled, false otherwise.
     */
    public function isEnabled() : bool;

}