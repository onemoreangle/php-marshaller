<?php

namespace OneMoreAngle\Marshaller\Inject;

use OneMoreAngle\Marshaller\Data\IntermediaryData;
use OneMoreAngle\Marshaller\Typing\TypeToken;

/**
 * @template R
 */
interface Injector {

    /**
     * @param IntermediaryData $data
     * @param TypeToken $token
     * @return R the deserialized data
     */
    public function reconstruct(IntermediaryData $data, TypeToken $token);
}