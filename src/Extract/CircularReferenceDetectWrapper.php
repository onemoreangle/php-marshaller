<?php

namespace OneMoreAngle\Marshaller\Extract;

use OneMoreAngle\Marshaller\Data\Serializable;
use OneMoreAngle\Marshaller\Exception\CircularReferenceException;
use SplObjectStorage;

/**
 * Class CircularReferenceDetectWrapper
 *
 * This class is used to detect circular references in the data being marshalled. To
 * do this, we use a SplObjectStorage to keep track of the objects we've seen. If we
 * see an object twice, we know we have a circular reference because the object is
 * removed from the stack once it has been entirely processed, so it must have been
 * a reference to the original object. This does mean that the extraction process
 * must maintain a reference to the same instance of this class, otherwise the
 * extracted properties are not checked against the same stack.
 */
class CircularReferenceDetectWrapper {
    protected SplObjectStorage $objectStack;

    public function __construct() {
        $this->objectStack = new SplObjectStorage();
    }

    /**
     * @throws CircularReferenceException
     */
    public function execute(object $data, callable $fn) : Serializable {
        if ($this->objectStack->contains($data)) {
            throw new CircularReferenceException();
        }

        $this->objectStack->attach($data);
        $result = $fn($data);
        $this->objectStack->detach($data);
        return $result;
    }
}