<?php

namespace OneMoreAngle\Marshaller\Meta;

use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;

/**
 * Defines an interface for extracting metadata from classes, properties and
 * methods, using annotations or attributes of the given reflection objects.
 */
interface MetaExtractor {

    /**
     * @template T of object
     * @param ReflectionClass $class
     * @param class-string<T> $annotation
     * @return T|null
     */
    public function extractFromClass(ReflectionClass $class, string $annotation) : ?object;

    /**
     * @template T of object
     * @param ReflectionProperty $property
     * @param class-string<T> $annotation
     * @return T|null
     */
    public function extractFromProperty(ReflectionProperty $property, string $annotation) : ?object;

    /**
     * @template T of object
     * @param ReflectionMethod $method
     * @param class-string<T> $annotation
     * @return T|null
     */
    public function extractFromMethod(ReflectionMethod $method, string $annotation) : ?object;
}