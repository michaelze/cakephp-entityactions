<?php
namespace EntityActions\EntityAction;

/**
 * Objects of this class contain information about an entity action processed for a certain entity and request.
 */
class ProcessedEntityAction implements IProcessedEntityAction {

    private $label;
    private $class;
    private $url;
    private $authorized;
    private $enabled;

    public function __construct(string $label, string $class, array $url, bool $authorized, bool $enabled) {
        $this->label = $label;
        $this->class = $class;
        $this->url = $url;
        $this->authorized = $authorized;
        $this->enabled = $enabled;
    }

    public function getLabel() : string {
        return $this->lable;
    }

    public function getClass() : string {
        return $this->class;
    }

    public function getUrl() : array {
        return $this->url;
    }

    public function isAuthorized(): bool {
        return $this->authorized;
    }

    public function isEnabled(): bool {
        return $this->enabled;
    }

}