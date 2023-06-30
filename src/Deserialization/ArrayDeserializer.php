<?php

namespace OneMoreAngle\Marshaller\Deserialization;

class ArrayDeserializer implements Deserializer {
    protected $deserializerFactory;

    public function __construct(DeserializerFactory $deserializerFactory) {
        $this->deserializerFactory = $deserializerFactory;
    }

    public function deserialize($data) {
        $result = [];
        $deserializer = $this->deserializerFactory->create($this->elementType);

        foreach ($data as $key => $value) {
            // must get type tokens of $value here, then get a deserializer for them with context. $value may not ever
            // be anything else than a scalar or an array, since we deserialize from array structured data
            $result[$key] = $deserializer->deserialize($value);
        }

        return $result;
    }
}