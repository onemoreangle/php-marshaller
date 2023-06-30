<?php

namespace OneMoreAngle\Marshaller\Deserialization;

/**
 * @template T
 * @template R
 */
interface Deserializer {

    /**
     * @param T $data
     * @return R the deserialized data
     */
    public function deserialize($data) : mixed;
}