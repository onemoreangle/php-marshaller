<?php

namespace OneMoreAngle\Marshaller\Encode;

interface Encoder {
    public function encode($data, $context = null) : string;
}