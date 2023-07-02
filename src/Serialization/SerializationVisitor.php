<?php

namespace OneMoreAngle\Marshaller\Serialization;

use OneMoreAngle\Marshaller\Data\IntermediaryData;
interface SerializationVisitor {
    public function serialize(IntermediaryData $data);
    public function deserialize($input) : IntermediaryData;
}