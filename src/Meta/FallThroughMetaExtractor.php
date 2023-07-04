<?php

namespace OneMoreAngle\Marshaller\Meta;

use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;

class FallThroughMetaExtractor implements MetaExtractor {
    /**
     * @var MetaExtractor[]
     */
    private array $extractors;

    /**
     * @param MetaExtractor[] $extractors
     */
    public function __construct(array $extractors = []) {
        $this->extractors = $extractors;
    }

    public function addExtractor(MetaExtractor $extractor): self {
        $this->extractors[] = $extractor;
        return $this;
    }

    /**
     * @template T
     * @param callable(MetaExtractor):T $method
     * @param callable(T): bool $isEmpty
     * @return T|null
     */

    private function fallThroughExtract(callable $method, callable $isEmpty) {
        foreach ($this->extractors as $extractor) {
            $result = $method($extractor);
            if (!$isEmpty($result)) {
                return $result;
            }
        }
        return null;
    }

    /**
     * @template T of object
     * @param ReflectionClass $class
     * @param class-string<T> $annotation
     * @return object|null
     */
    public function extractFromClass(ReflectionClass $class, string $annotation): ?object {
        return $this->fallThroughExtract(fn($extractor) => $extractor->extractFromClass($class, $annotation), fn($result) => $result === null);
    }

    /**
     * @param ReflectionClass $class
     * @return object[]
     */
    public function extractAllFromClass(ReflectionClass $class): array {
        return $this->fallThroughExtract(fn($extractor) => $extractor->extractAllFromClass($class), fn($result) => empty($result)) ?? [];
    }


    /**
     * @template T of object
     * @param ReflectionProperty $property
     * @param class-string<T> $annotation
     * @return object|null
     */
    public function extractFromProperty(ReflectionProperty $property, string $annotation): ?object {
        return $this->fallThroughExtract(fn($extractor) => $extractor->extractFromProperty($property, $annotation), fn($result) => $result === null);
    }

    public function extractAllFromProperty(ReflectionProperty $property): array {
        return $this->fallThroughExtract(fn($extractor) => $extractor->extractAllFromProperty($property), fn($result) => empty($result)) ?? [];
    }


    /**
     * @template T of object
     * @param ReflectionMethod $method
     * @param class-string<T> $annotation
     * @return object|null
     */
    public function extractFromMethod(ReflectionMethod $method, string $annotation): ?object {
        return $this->fallThroughExtract(fn($extractor) => $extractor->extractFromMethod($method, $annotation), fn($result) => $result === null);
    }

    public function extractAllFromMethod(ReflectionMethod $method): array {
        return $this->fallThroughExtract(fn($extractor) => $extractor->extractAllFromMethod($method), fn($result) => empty($result)) ?? [];
    }

    /**
     * @return MetaExtractor[]
     */
    public function getExtractors() : array {
        return $this->extractors;
    }
}