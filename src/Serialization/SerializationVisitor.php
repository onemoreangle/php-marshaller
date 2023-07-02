<?php

namespace OneMoreAngle\Marshaller\Serialization;

use OneMoreAngle\Marshaller\Data\Serializable;
use OneMoreAngle\Marshaller\Typing\ArrayTypeToken;
use OneMoreAngle\Marshaller\Typing\ClassTypeToken;
use OneMoreAngle\Marshaller\Typing\PrimitiveTypeToken;

interface SerializationVisitor {
    public function serialize(Serializable $data);
    public function deserialize($input);
}