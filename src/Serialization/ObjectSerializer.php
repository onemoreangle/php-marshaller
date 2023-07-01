<?php

namespace OneMoreAngle\Marshaller\Serialization;

use OneMoreAngle\Marshaller\Exception\CircularReferenceException;
use ReflectionClass;
use ReflectionException;

class ObjectSerializer implements Serializer {
    protected Marshaller $marshaller;
    protected string $class;

    public function __construct(Marshaller $marshaller, string $class) {
        $this->marshaller = $marshaller;
        $this->class = $class;
    }

    /**
     * @throws ReflectionException
     * @throws CircularReferenceException
     */
    public function serialize($data) {
        $reflection = new ReflectionClass($this->class);
        $result = [];

        foreach ($reflection->getProperties() as $property) {
            $property->setAccessible(true);
            $value = $property->getValue($data);
            $propertyName = $property->getName();
            // use a stage process to get metadata
            $result[$propertyName] = $this->marshaller->marshall($value);
        }
        return $result;
    }
}