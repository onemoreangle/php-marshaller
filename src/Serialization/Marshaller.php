<?php

namespace OneMoreAngle\Marshaller\Serialization;

use OneMoreAngle\Marshaller\Exception\CircularReferenceException;
use OneMoreAngle\Marshaller\Typing\TypeTokenFactory;
use SplObjectStorage;

/**
 * TODO: make the design of this class better, object serialization requires
 * a process overview, which is not reliably or neatly possible with new
 * instances of serializers for each specific class
 */
class Marshaller implements Serializer {
    private SerializerFactory $serializerFactory;
    private SplObjectStorage $objectStack;

    public function __construct(SerializerFactory $serializerFactory) {
        $this->serializerFactory = $serializerFactory;
        $this->objectStack = new SplObjectStorage();
    }

    /**
     * @throws CircularReferenceException
     */
    public function serialize($data) {
        if (is_object($data) && $this->objectStack->contains($data)) {
            throw new CircularReferenceException();
        }

        $typeToken = TypeTokenFactory::tokenize($data);
        $serializer = $this->serializerFactory->create($typeToken);

        if (is_object($data)) {
            $this->objectStack->attach($data);
        }

        $serializedData = $serializer->serialize($data, $this);

        if (is_object($data)) {
            $this->objectStack->detach($data);
        }

        return $serializedData;
    }
}