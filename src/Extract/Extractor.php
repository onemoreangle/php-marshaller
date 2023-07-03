<?php

namespace OneMoreAngle\Marshaller\Extract;

use OneMoreAngle\Marshaller\Data\IntermediaryData;
use OneMoreAngle\Marshaller\Exception\CircularReferenceException;
use OneMoreAngle\Marshaller\Typing\TypeToken;

/**
 * @template T
 */
interface Extractor {

    /**
     * @param T $data
     * @param TypeToken $token
     * @return IntermediaryData
     * @throws CircularReferenceException
     */
    public function extract($data, TypeToken $token) : IntermediaryData;
}