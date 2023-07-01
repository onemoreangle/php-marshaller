<?php

namespace OneMoreAngle\Marshaller\Meta;

use Exception;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;

class DoctrineAnnotationMetaExtractor implements MetaExtractor {

    private object $reader;

    /**
     * @param object|null $reader
     * @throws Exception
     */
    public function __construct(object $reader = null) {
        if (!class_exists('\Doctrine\Common\Annotations\AnnotationReader')) {
            throw new Exception('Doctrine\Common\Annotations\AnnotationReader is required to use DoctrineAnnotationMetaExtractor, switch MetaExtractor implementation or run: composer require doctrine/annotations');
        }

        if(!(is_a($reader, '\Doctrine\Common\Annotations\AnnotationReader'))) {
            $reader = new \Doctrine\Common\Annotations\AnnotationReader();
        }

        $this->reader = new \Doctrine\Common\Annotations\AnnotationReader();
    }

    /**
     * @template T
     * @param ReflectionClass $class
     * @param class-string<T> $annotation
     * @return T|null
     * @throws Exception
     */
    public function extractFromClass(ReflectionClass $class, string $annotation): ?object {
        return $this->reader->getClassAnnotation($class, $annotation);
    }

    /**
     * @template T
     * @param ReflectionProperty $property
     * @param class-string<T> $annotation
     * @return T|null
     * @throws Exception
     */
    public function extractFromProperty(ReflectionProperty $property, string $annotation): ?object {
        return $this->reader->getPropertyAnnotation($property, $annotation);
    }

    /**
     * @template T
     * @param ReflectionMethod $method
     * @param class-string<T> $annotation
     * @return T|null
     * @throws Exception
     */
    public function extractFromMethod(ReflectionMethod $method, string $annotation): ?object {
        return $this->reader->getMethodAnnotation($method, $annotation);
    }
}