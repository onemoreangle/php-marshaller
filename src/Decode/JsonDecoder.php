<?php

namespace OneMoreAngle\Marshaller\Decode;

class JsonDecoder implements Decoder {

    public function decode(string $data, $context = null) {
        return json_decode($data, true);
    }
}