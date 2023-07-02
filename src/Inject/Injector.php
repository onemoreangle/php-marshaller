<?php

namespace OneMoreAngle\Marshaller\Inject;

use OneMoreAngle\Marshaller\Data\Serializable;
use OneMoreAngle\Marshaller\Typing\TypeToken;

/**
 * @template T
 * @template R
 */
interface Injector {

    /**
     * @param Serializable $data
     * @param TypeToken $token
     * @return R the deserialized data
     */
    public function reconstruct(Serializable $data, TypeToken $token);
}