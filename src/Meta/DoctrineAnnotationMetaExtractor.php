<?php

namespace OneMoreAngle\Marshaller\Meta;

use Doctrine\Common\Annotations\AnnotationReader;
use Exception;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;

class DoctrineAnnotationMetaExtractor implements MetaExtractor {

    /**
     * @var AnnotationReader $reader
     */
    private $reader;

    /**
     * @param object|null $reader
     * @throws Exception
     */
    public function __construct(object $reader = null) {
        if (!class_exists(AnnotationReader::class)) {
            throw new Exception(AnnotationReader::class . ' is required to use DoctrineAnnotationMetaExtractor, switch MetaExtractor implementation or run: composer require doctrine/annotations');
        }

        if($reader !== null && !is_a($reader, AnnotationReader::class)) {
            throw new Exception('DoctrineAnnotationMetaExtractor requires an instance of ' . AnnotationReader::class . ' or null');
        }

        $this->reader = $reader ?? new AnnotationReader();
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