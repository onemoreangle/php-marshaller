<?php

namespace OneMoreAngle\Marshaller\Inject;

use OneMoreAngle\Marshaller\Data\IntermediaryData;
use OneMoreAngle\Marshaller\Typing\TypeToken;

interface InjectionProcess {

    /**
     * @param IntermediaryData $data
     * @param TypeToken $token
     * @return mixed
     */
    public function reconstruct(IntermediaryData $data, TypeToken $token);
}