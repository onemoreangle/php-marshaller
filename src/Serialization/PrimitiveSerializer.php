<?php

namespace OneMoreAngle\Marshaller\Serialization;

class PrimitiveSerializer implements Serializer {

    public function serialize($data) {
        return $data;
    }
}