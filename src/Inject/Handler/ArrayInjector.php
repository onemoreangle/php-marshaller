<?php

namespace OneMoreAngle\Marshaller\Inject\Handler;

use OneMoreAngle\Marshaller\Data\Serializable;
use OneMoreAngle\Marshaller\Inject\InjectorManager;
use OneMoreAngle\Marshaller\Inject\Injector;
use OneMoreAngle\Marshaller\Typing\TypeToken;
use OneMoreAngle\Marshaller\Typing\TypeTokenFactory;

class ArrayInjector implements Injector {
    protected InjectorManager $deserializerFactory;

    public function __construct(InjectorManager $deserializerFactory) {
        $this->deserializerFactory = $deserializerFactory;
    }

    public function reconstruct(Serializable $data, TypeToken $token): mixed {
        $result = [];
        foreach ($data as $key => $value) {
            $deserialized = TypeTokenFactory::tokenize($value)->getInjector($this->deserializerFactory)->reconstruct($value);
            $result[$key] = $deserialized;
        }

        return $result;
    }
}