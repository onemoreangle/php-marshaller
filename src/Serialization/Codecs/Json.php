<?php

namespace OneMoreAngle\Marshaller\Serialization\Codecs;

use OneMoreAngle\Marshaller\Data\Serializable;
use OneMoreAngle\Marshaller\Serialization\SerializationVisitor;

class Json implements SerializationVisitor {

    public function serialize(Serializable $data) {
        return json_encode($data);
    }

    public function deserialize($input) {
        return json_decode($input);
    }
}