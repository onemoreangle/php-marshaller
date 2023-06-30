<?php

namespace OneMoreAngle\Marshaller\Serialization;

class ArraySerializer implements Serializer {

    public function serialize($data) {
        return $data;
    }
}