<?php

namespace OneMoreAngle\Marshaller\Inject\Handler;

use OneMoreAngle\Marshaller\Data\IntermediaryData;
use OneMoreAngle\Marshaller\Inject\Injector;
use OneMoreAngle\Marshaller\Typing\TypeToken;

/**
 * @template T
 * @template R
 * @template-extends Injector<T, R>
 */
class PrimitiveInjector implements Injector {
    public function reconstruct(IntermediaryData $data, TypeToken $token) {
        return $data->getValue();
    }
}