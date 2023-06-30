<?php

namespace OneMoreAngle\Marshaller\Serialization;

use OneMoreAngle\Marshaller\Exception\CircularReferenceException;
use OneMoreAngle\Marshaller\Meta\PropertyMetadataProvider;
use ReflectionClass;
use SplObjectStorage;

class ObjectSerializer implements Serializer {
    protected PropertyMetadataProvider $propertyMetadataProvider;
    protected SerializerFactory $serializerFactory;
    protected string $class;
    protected SplObjectStorage $objectStack;

    public function __construct(PropertyMetadataProvider $propertyMetadataProvider, SerializerFactory $serializerFactory, string $class) {
        $this->propertyMetadataProvider = $propertyMetadataProvider;
        $this->serializerFactory = $serializerFactory;
        $this->class = $class;
        $this->objectStack = new SplObjectStorage();
    }

    public function serialize($data) {
        if ($this->objectStack->contains($data)) {
            throw new CircularReferenceException();
        }

        $this->objectStack->attach($data);
        $reflection = new ReflectionClass($this->class);
        $result = [];

        foreach ($reflection->getProperties() as $property) {
            $property->setAccessible(true);
            $value = $property->getValue($data);
            $propertyName = $this->propertyMetadataProvider->getSerializationName($property);
            $typeToken = $this->propertyMetadataProvider->getTargetType($property);
            $serializer = $this->serializerFactory->create($typeToken);
            $result[$propertyName] = $serializer->serialize($value);
        }

        $this->objectStack->detach($data);
        return $result;
    }
}