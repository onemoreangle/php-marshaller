<?php

namespace OneMoreAngle\Marshaller\Deserialization;

use OneMoreAngle\Marshaller\Typing\TypeTokenFactory;

class ArrayDeserializer implements Deserializer {
    protected DeserializerFactory $deserializerFactory;

    public function __construct(DeserializerFactory $deserializerFactory) {
        $this->deserializerFactory = $deserializerFactory;
    }

    public function deserialize($data): mixed {
        $result = [];
        foreach ($data as $key => $value) {
            // TODO: cache deserializers
            $deserialized = TypeTokenFactory::tokenize($value)->getDeserializer($this->deserializerFactory)->deserialize($value);
            $result[$key] = $deserialized;
        }

        return $result;
    }
}