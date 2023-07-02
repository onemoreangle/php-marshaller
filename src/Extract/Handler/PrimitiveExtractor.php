<?php

namespace OneMoreAngle\Marshaller\Extract\Handler;

use OneMoreAngle\Marshaller\Data\IntermediaryData;
use OneMoreAngle\Marshaller\Extract\Extractor;
use OneMoreAngle\Marshaller\Typing\TypeToken;

class PrimitiveExtractor implements Extractor {

    public function extract($data, TypeToken $token): IntermediaryData {
        // extract meta from data
        return new IntermediaryData($data, $token);
    }
}