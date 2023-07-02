<?php

namespace OneMoreAngle\Marshaller\Extract\Handler;

use OneMoreAngle\Marshaller\Data\Serializable;
use OneMoreAngle\Marshaller\Extract\ExtractionManager;
use OneMoreAngle\Marshaller\Extract\Extractor;

class ArrayExtractor implements Extractor {

    private ExtractionManager $extractor;

    public function __construct(ExtractionManager $extractor) {
        $this->extractor = $extractor;
    }

    public function extract($data): Serializable {
        $result = new Serializable();

        foreach ($data as $key => $value) {
            $result[$key] = $this->extractor->extract($value);
        }

        return $result;
    }
}