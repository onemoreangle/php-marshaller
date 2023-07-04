<?php

namespace OneMoreAngle\Marshaller\Inject\Handler;

use Exception;
use OneMoreAngle\Marshaller\Data\IntermediaryData;
use OneMoreAngle\Marshaller\Inject\InjectionManager;
use OneMoreAngle\Marshaller\Inject\Injector;
use OneMoreAngle\Marshaller\Typing\ArrayTypeToken;
use OneMoreAngle\Marshaller\Typing\TypeToken;
use OneMoreAngle\Marshaller\Typing\TypeTokenFactory;

class ArrayInjector implements Injector {
    protected InjectionManager $deserializerFactory;

    public function __construct(InjectionManager $deserializerFactory) {
        $this->deserializerFactory = $deserializerFactory;
    }

    /**
     * @param IntermediaryData<IntermediaryData[]> $data
     * @param ArrayTypeToken $token
     * @return array<mixed>
     * @throws Exception
     */
    public function reconstruct(IntermediaryData $data, TypeToken $token) {
        if($data->getValue() === null) {
            // This shouldn't ever happen because of the type system, null values should be delegated to the primitive injector
            throw new Exception("Cannot deserialize null into object, invalid state");
        }

        $result = [];
        foreach ($data->getValue() as $key => $value) {
            $typeToken = $token->getArrayType() ?? TypeTokenFactory::tokenize($value->getValue());
            // TODO: the type token cannot accurately be determined from the data as we are in an array which is not typed, use attributes from defining classes
            $deserialized = $this->deserializerFactory->reconstruct($value, $typeToken);
            $result[$key] = $deserialized;
        }

        return $result;
    }
}