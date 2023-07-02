<?php

namespace OneMoreAngle\Marshaller\Extract;

use OneMoreAngle\Marshaller\Data\Serializable;

interface Extractor {
    public function extract($data) : Serializable;
}