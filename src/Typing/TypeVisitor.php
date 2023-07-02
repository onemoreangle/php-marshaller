<?php

namespace OneMoreAngle\Marshaller\Typing;

use OneMoreAngle\Marshaller\Data\IntermediaryData;

interface TypeVisitor {
    public function visitPrimitive(IntermediaryData $data);

    public function visitObject(IntermediaryData $data);

    public function visitArray(IntermediaryData $data);
}