<?php

namespace OneMoreAngle\Marshaller\Inject\Handler;

use OneMoreAngle\Marshaller\Data\IntermediaryData;
use OneMoreAngle\Marshaller\Inject\Injector;
use OneMoreAngle\Marshaller\Typing\TypeToken;

/**
 * @template R
 * @template-implements Injector<R>
 */
class PrimitiveInjector implements Injector {
    public function reconstruct(IntermediaryData $data, TypeToken $token) {
        return $data->getValue();
    }
}