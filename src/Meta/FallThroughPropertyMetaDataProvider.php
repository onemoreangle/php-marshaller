<?php

namespace OneMoreAngle\Marshaller\Meta;

use OneMoreAngle\Marshaller\Typing\TypeToken;
use ReflectionProperty;

class FallThroughPropertyMetaDataProvider implements PropertyMetadataProvider {
    /**
     * @var PropertyMetadataProvider[]
     */
    private array $providers;

    public function __construct(array $providers = []) {
        $this->providers = $providers;
    }

    public function addProvider(PropertyMetadataProvider $provider): self {
        $this->providers[] = $provider;
        return $this;
    }

    public function getSerializationName(ReflectionProperty $property): ?string {
        foreach ($this->providers as $provider) {
            $name = $provider->getSerializationName($property);
            if ($name !== null) {
                return $name;
            }
        }
        return null;
    }

    public function getSerializationAliases(ReflectionProperty $property): array {
        foreach ($this->providers as $provider) {
            $aliases = $provider->getSerializationAliases($property);
            if (!empty($aliases)) {
                return $aliases;
            }
        }
        return [];
    }

    public function getTargetType(ReflectionProperty $property): ?TypeToken {
        foreach ($this->providers as $provider) {
            $type = $provider->getTargetType($property);
            if ($type !== null) {
                return $type;
            }
        }
        return null;
    }

    public function isOmitEmpty(ReflectionProperty $property): ?bool {
        foreach ($this->providers as $provider) {
            $omit = $provider->isOmitEmpty($property);
            if ($omit !== null) {
                return $omit;
            }
        }
        return null;
    }
}