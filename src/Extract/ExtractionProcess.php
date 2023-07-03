<?php

namespace OneMoreAngle\Marshaller\Extract;

use OneMoreAngle\Marshaller\Data\IntermediaryData;
use OneMoreAngle\Marshaller\Implementation\Process;

interface ExtractionProcess extends Process {

    /**
     * @param mixed $data
     * @return IntermediaryData
     */
    public function extract($data) : IntermediaryData;
}