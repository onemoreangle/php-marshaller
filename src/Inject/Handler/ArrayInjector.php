<?php

namespace OneMoreAngle\Marshaller\Inject\Handler;

use OneMoreAngle\Marshaller\Data\IntermediaryData;
use OneMoreAngle\Marshaller\Inject\InjectorManager;
use OneMoreAngle\Marshaller\Inject\Injector;
use OneMoreAngle\Marshaller\Typing\TypeToken;
use OneMoreAngle\Marshaller\Typing\TypeTokenFactory;

class ArrayInjector implements Injector {
    protected InjectorManager $deserializerFactory;

    public function __construct(InjectorManager $deserializerFactory) {
        $this->deserializerFactory = $deserializerFactory;
    }

    public function reconstruct(IntermediaryData $data, TypeToken $token) {
        $result = [];
        foreach ($data->getValue() as $key => $value) {
            $typeToken = TypeTokenFactory::tokenize($value);
            // TODO: the type token cannot accurately be determined from the data as we are in an array which is not typed, use attributes
            $deserialized = TypeTokenFactory::tokenize($value)->getInjector($this->deserializerFactory)->reconstruct($value, $typeToken);
            $result[$key] = $deserialized;
        }

        return $result;
    }
}