<?php

namespace OneMoreAngle\Marshaller\Deserialization;

/**
 * @template T
 * @template R
 * @template-extends Deserializer<T, R>
 */
class PrimitiveDeserializer implements Deserializer{
    public function deserialize($data): mixed {
        return $data;
    }
}