<?php

namespace OneMoreAngle\Marshaller\Extract;

use OneMoreAngle\Marshaller\Data\IntermediaryData;

interface ExtractionProcess {

    /**
     * @param mixed $data
     * @return IntermediaryData
     */
    public function extract($data) : IntermediaryData;
}