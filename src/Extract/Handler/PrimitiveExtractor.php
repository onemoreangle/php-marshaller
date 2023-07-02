<?php

namespace OneMoreAngle\Marshaller\Extract\Handler;

use OneMoreAngle\Marshaller\Data\Serializable;
use OneMoreAngle\Marshaller\Extract\Extractor;

class PrimitiveExtractor implements Extractor {

    public function extract($data): Serializable {
        $result = new Serializable();
        $result->data = $data;
        return $result;
    }
}