<?php

namespace OneMoreAngle\Marshaller\Data;

/**
 * @template T of object
 */
class ExtractionMetaData {
    /**
     * @var array<class-string<T>, T>
     */
    private array $annotations;

    /**
     * @param array<T> $annotations
     */
    public function __construct(array $annotations = []) {
        $this->annotations = [];
        foreach($annotations as $annotation) {
            $this->annotations[get_class($annotation)] = $annotation;
        }
    }

    /**
     * @param class-string<T> $name
     * @return T|null
     */
    public function getAnnotation(string $name) {
        return $this->annotations[$name] ?? null;
    }

    /**
     * @param class-string<T> $name
     * @return bool
     */
    public function hasAnnotation(string $name): bool {
        return isset($this->annotations[$name]);
    }

    /**
     * @return object[]
     */
    public function getAnnotations(): array {
        return $this->annotations;
    }
}