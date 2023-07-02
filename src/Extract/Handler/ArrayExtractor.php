<?php

namespace OneMoreAngle\Marshaller\Extract\Handler;

use OneMoreAngle\Marshaller\Data\IntermediaryData;
use OneMoreAngle\Marshaller\Extract\ExtractionManager;
use OneMoreAngle\Marshaller\Extract\Extractor;
use OneMoreAngle\Marshaller\Typing\TypeToken;

class ArrayExtractor implements Extractor {

    private ExtractionManager $extractor;

    public function __construct(ExtractionManager $extractor) {
        $this->extractor = $extractor;
    }

    public function extract($data, TypeToken $token): IntermediaryData {
        $result = [];

        foreach ($data as $key => $value) {
            $result[$key] = $this->extractor->extract($value);
        }

        return new IntermediaryData($result, $token);
    }
}