<?php

namespace OneMoreAngle\Marshaller\Meta;

use Exception;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;

class AttributeMetaExtractor implements MetaExtractor {

    /**
     * @template T of object
     * @param ReflectionClass $class
     * @param class-string<T> $annotation
     * @return T|null
     * @throws Exception
     */
    public function extractFromClass(ReflectionClass $class, string $annotation): ?object {
        return static::getAttributeForReflectionObject($class, $annotation);
    }

    /**
     * @template T of object
     * @param ReflectionProperty $property
     * @param class-string<T> $annotation
     * @return T|null
     * @throws Exception
     */
    public function extractFromProperty(ReflectionProperty $property, string $annotation): ?object {
        return static::getAttributeForReflectionObject($property, $annotation);
    }

    /**
     * @template T of object
     * @param ReflectionMethod $method
     * @param class-string<T> $annotation
     * @return T|null
     * @throws Exception
     */
    public function extractFromMethod(ReflectionMethod $method, string $annotation): ?object {
        return static::getAttributeForReflectionObject($method, $annotation);
    }

    /**
     * @template T of object
     * @param ReflectionProperty|ReflectionClass|ReflectionMethod $property
     * @param class-string<T> $attributeClass
     * @return T|null
     * @throws Exception
     */
    protected static function getAttributeForReflectionObject($property, string $attributeClass) {
        if (!version_compare(PHP_VERSION, '8.0.0', '>=')) {
            throw new Exception('PHP 8.0.0 or higher is required to use PhpAttributeReader');
        }

        $attributes = $property->getAttributes($attributeClass);
        return $attributes ? $attributes[0]->newInstance() : null;
    }
}