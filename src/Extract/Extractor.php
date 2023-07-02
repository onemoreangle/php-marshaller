<?php

namespace OneMoreAngle\Marshaller\Extract;

use OneMoreAngle\Marshaller\Data\IntermediaryData;
use OneMoreAngle\Marshaller\Typing\TypeToken;

interface Extractor {
    public function extract($data, TypeToken $token) : IntermediaryData;
}