<?php

namespace OneMoreAngle\Marshaller\Inject;

use OneMoreAngle\Marshaller\Data\IntermediaryData;
use OneMoreAngle\Marshaller\Implementation\Process;
use OneMoreAngle\Marshaller\Typing\TypeToken;

interface InjectionProcess extends Process {

    /**
     * @param IntermediaryData $data
     * @param TypeToken $token
     * @return mixed
     */
    public function reconstruct(IntermediaryData $data, TypeToken $token);
}