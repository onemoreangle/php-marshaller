<?php

namespace OneMoreAngle\Marshaller\Decode;

/**
 * @template T
 */
interface Decoder {

    /**
     * @param string $data
     * @param $context
     * @return T
     */
    public function decode(string $data, $context = null);
}