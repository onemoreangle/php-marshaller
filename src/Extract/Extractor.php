<?php

namespace OneMoreAngle\Marshaller\Extract;

use OneMoreAngle\Marshaller\Data\IntermediaryData;
use OneMoreAngle\Marshaller\Exception\CircularReferenceException;
use OneMoreAngle\Marshaller\Typing\TypeToken;

interface Extractor {

    /**
     * @param $data
     * @param TypeToken $token
     * @return IntermediaryData
     * @throws CircularReferenceException
     */
    public function extract($data, TypeToken $token) : IntermediaryData;
}