<?php

namespace OneMoreAngle\Marshaller\Typing;

use OneMoreAngle\Marshaller\Data\IntermediaryData;

interface TypeVisitor {
    public function visitPrimitive(IntermediaryData $data) : void;

    public function visitObject(IntermediaryData $data) : void;

    public function visitArray(IntermediaryData $data) : void;
}