<?php

namespace OneMoreAngle\Marshaller\Extract;

use OneMoreAngle\Marshaller\Data\IntermediaryData;
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
     * $fn is a function intended to operate on the $data object, performing
     * any necessary traversal on its properties. If any of these properties
     * are objects, this should result in a call to execute(...) in the same way
     * that it did for the original object. This is how this class is able to
     * detect circular references, granted that the same instance of this class
     * is used throughout the extraction process.
     *
     * @param object $data
     * @param callable $fn
     * @return IntermediaryData
     * @throws CircularReferenceException
     */
    public function execute(object $data, callable $fn) : IntermediaryData {
        if ($this->objectStack->contains($data)) {
            throw new CircularReferenceException();
        }

        $this->objectStack->attach($data);
        $result = $fn($data);
        $this->objectStack->detach($data);
        return $result;
    }
}