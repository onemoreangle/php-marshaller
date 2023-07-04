<?php

namespace OneMoreAngle\Marshaller\Meta;

use Exception;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;

class DoctrineAnnotationMetaExtractor implements MetaExtractor {

    /**
     * @var \Doctrine\Common\Annotations\AnnotationReader $reader
     */
    private $reader;

    /**
     * @param object|null $reader
     * @throws Exception
     */
    public function __construct(object $reader = null) {
        if (!class_exists('\Doctrine\Common\Annotations\AnnotationReader')) {
            throw new Exception('Doctrine\Common\Annotations\AnnotationReader is required to use DoctrineAnnotationMetaExtractor, switch MetaExtractor implementation or run: composer require doctrine/annotations');
        }

        if($reader !== null && !is_a($reader, '\Doctrine\Common\Annotations\AnnotationReader')) {
            throw new Exception('DoctrineAnnotationMetaExtractor requires an instance of Doctrine\Common\Annotations\AnnotationReader');
        }

        $this->reader = $reader ?? new \Doctrine\Common\Annotations\AnnotationReader();
    }

    /**
     * @template T of object
     * @param ReflectionClass $class
     * @param class-string<T> $annotation
     * @return T|null
     * @throws Exception
     */
    public function extractFromClass(ReflectionClass $class, string $annotation): ?object {
        return $this->reader->getClassAnnotation($class, $annotation);
    }

    /**
     * @template T of object
     * @param ReflectionProperty $property
     * @param class-string<T> $annotation
     * @return T|null
     * @throws Exception
     */
    public function extractFromProperty(ReflectionProperty $property, string $annotation): ?object {
        return $this->reader->getPropertyAnnotation($property, $annotation);
    }

    /**
     * @template T of object
     * @param ReflectionMethod $method
     * @param class-string<T> $annotation
     * @return T|null
     * @throws Exception
     */
    public function extractFromMethod(ReflectionMethod $method, string $annotation): ?object {
        return $this->reader->getMethodAnnotation($method, $annotation);
    }

    public function extractAllFromClass(ReflectionClass $class): array {
        return $this->reader->getClassAnnotations($class);
    }

    public function extractAllFromProperty(ReflectionProperty $property): array {
        return $this->reader->getPropertyAnnotations($property);
    }

    public function extractAllFromMethod(ReflectionMethod $method): array {
        return $this->reader->getMethodAnnotations($method);
    }
}