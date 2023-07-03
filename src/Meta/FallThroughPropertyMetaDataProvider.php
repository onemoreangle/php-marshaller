<?php

namespace OneMoreAngle\Marshaller\Meta;

use OneMoreAngle\Marshaller\Typing\TypeToken;
use ReflectionProperty;

class FallThroughPropertyMetaDataProvider implements PropertyMetadataProvider {
    /**
     * @var PropertyMetadataProvider[]
     */
    private array $providers;

    /**
     * @param PropertyMetadataProvider[] $providers
     */
    public function __construct(array $providers = []) {
        $this->providers = $providers;
    }

    public function addProvider(PropertyMetadataProvider $provider): self {
        $this->providers[] = $provider;
        return $this;
    }

    /**
     * @template T
     * @param callable(PropertyMetadataProvider):T $method
     * @param callable(T): bool $isEmpty
     * @return T|null
     */
    private function fallthroughFetch(callable $method, callable $isEmpty) {
        foreach ($this->providers as $provider) {
            $result = $method($provider);
            if (!$isEmpty($result)) {
                return $result;
            }
        }
        return null;
    }

    public function getSerializationName(ReflectionProperty $property): ?string {
        return $this->fallthroughFetch(fn($provider) => $provider->getSerializationName($property), fn($result) => $result === null);
    }

    /**
     * @param ReflectionProperty $property
     * @return string[]
     */
    public function getSerializationAliases(ReflectionProperty $property): array {
        return $this->fallthroughFetch(fn($provider) => $provider->getSerializationAliases($property), fn($result) => empty($result)) ?? [];
    }

    public function getTargetType(ReflectionProperty $property): ?TypeToken {
        return $this->fallthroughFetch(fn($provider) => $provider->getTargetType($property), fn($result) => $result === null);
    }

    public function isOmitEmpty(ReflectionProperty $property): ?bool {
        return $this->fallthroughFetch(fn($provider) => $provider->isOmitEmpty($property), fn($result) => $result === null);
    }

    public function isOmit(ReflectionProperty $property): ?bool {
        return $this->fallthroughFetch(fn($provider) => $provider->isOmit($property), fn($result) => $result === null);
    }
}