<?php
namespace EntityActions\EntityAction;

use Cake\ORM\Entity;
use Cake\Http\ServerRequest;

/**
 * This class provides means of creating IProcessedEntityAction objects out of IEntityAction objects and an entity.
 */
class EntityActionProcessor {

    /**
     * @param IEntityAction $entityAction
     *          The entity action to process.
     * @param Entity $entity
     *          The entity to use for processing
     * @param ServerRequest $request
     *          The current request.
     * @return IProcessedEntityAction
     *          Returns an IProcessedEntityAction object that contains the properties of the provided entity action object processed using the
     *          provided entity and server request.
     */
    public function process(IEntityAction $entityAction, Entity $entity, ServerRequest $request) : IProcessedEntityAction {
        $label = $entityAction->getLabel();
        $class = $entityAction->getClass();
        $url = $entityAction->getUrl($entity);
        $authorized = $entityAction->isAuthorized($entity, $request->getSession()->read('Auth.User.id'), $request);
        $enabled = $entityAction->isEnabled($entity);
        return new ProcessedEntityAction($label, $class, $url, $authorized, $enabled);
    }

}