<?php

namespace OneMoreAngle\Marshaller\Serialization;

use SplObjectStorage;

class Context {
    private SplObjectStorage $objectStack;

    public function __construct() {
        $this->objectStack = new SplObjectStorage();
    }

    public function pushToStack($object) {
        $this->objectStack->attach($object);
    }

    public function popFromStack($object) {
        $this->objectStack->detach($object);
    }
}