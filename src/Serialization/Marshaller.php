<?php

namespace OneMoreAngle\Marshaller\Serialization;

use OneMoreAngle\Marshaller\Exception\CircularReferenceException;
use OneMoreAngle\Marshaller\Typing\TypeTokenFactory;
use SplObjectStorage;

class Marshaller {
    private SerializationManager $serializerFactory;
    private SplObjectStorage $objectStack;

    public function __construct(SerializationManager $serializerFactory) {
        $this->serializerFactory = $serializerFactory;
        $this->objectStack = new SplObjectStorage();
    }

    /**
     * @throws CircularReferenceException
     */
    public function marshall($data) {
        if (is_object($data) && $this->objectStack->contains($data)) {
            throw new CircularReferenceException();
        }

        $typeToken = TypeTokenFactory::tokenize($data);
        $serializer = $this->serializerFactory->create($typeToken);

        if (is_object($data)) {
            $this->objectStack->attach($data);
        }

        $serializedData = $serializer->serialize($data);

        if (is_object($data)) {
            $this->objectStack->detach($data);
        }

        return $serializedData;
    }
}