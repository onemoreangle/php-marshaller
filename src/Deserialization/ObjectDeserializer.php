<?php

namespace OneMoreAngle\Marshaller\Deserialization;

use OneMoreAngle\Marshaller\Meta\PropertyMetadataProvider;
use ReflectionClass;
use ReflectionException;

/**
 * @template R of object
 * @implements Deserializer<array, R>
 */
class ObjectDeserializer implements Deserializer {
    protected $class;
    protected $propertyMetadataProvider;
    protected $deserializerFactory;

    /**
     * @param string $class <R> $class
     * @param PropertyMetadataProvider $propertyMetadataProvider
     * @param DeserializerFactory $deserializerFactory
     */
    public function __construct(string $class, PropertyMetadataProvider $propertyMetadataProvider, DeserializerFactory $deserializerFactory) {
        $this->class = $class;
        $this->propertyMetadataProvider = $propertyMetadataProvider;
        $this->deserializerFactory = $deserializerFactory;
    }

    /**
     * @param $data
     * @return R the deserialized data which is an instance of the class passed in the constructor
     * @throws ReflectionException
     */
    public function deserialize($data): mixed {
        $object = new $this->class();
        $reflection = new ReflectionClass($this->class);

        foreach ($data as $propertyName => $propertyValue) {
            $reflectionProperty = $reflection->getProperty($propertyName);
            $reflectionProperty->setAccessible(true);
            $typeToken = $this->propertyMetadataProvider->getTargetType($reflectionProperty);
            $deserializer = $this->deserializerFactory->create($typeToken);
            $reflectionProperty->setValue($object, $deserializer->deserialize($propertyValue));
        }

        return $object;
    }
}