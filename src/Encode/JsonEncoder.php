<?php

namespace OneMoreAngle\Marshaller\Encode;

class JsonEncoder implements Encoder {

    public function encode($data, $context = null) : string {
        return json_encode($data);
    }
}