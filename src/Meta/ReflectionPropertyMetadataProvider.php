<?php

namespace OneMoreAngle\Marshaller\Meta;

use OneMoreAngle\Marshaller\Exception\UnresolvedTargetTypeException;
use OneMoreAngle\Marshaller\Typing\TypeToken;
use OneMoreAngle\Marshaller\Typing\TypeTokenFactory;
use ReflectionNamedType;
use ReflectionProperty;

class ReflectionPropertyMetadataProvider implements PropertyMetadataProvider {

    public function getSerializationName(ReflectionProperty $property): ?string {
        return $property->getName();
    }

    public function getSerializationAliases(ReflectionProperty $property): array {
        return []; // Add logic to find aliases
    }

    /**
     * @throws UnresolvedTargetTypeException
     */
    public function getTargetType(ReflectionProperty $property): ?TypeToken {
        $type = $property->getType();
        if ($type === null) {
            return null;
        }

        if(!($type instanceof ReflectionNamedType)) {
            // reflection based types are a last resort in every implementation, so we throw an exception
            throw new UnresolvedTargetTypeException("Cannot resolve type for property {$property->getName()} in class {$property->getDeclaringClass()->getName()}.");
        }

        return TypeTokenFactory::fromNamedType($type->getName());
    }

    public function isOmitEmpty(ReflectionProperty $property): ?bool {
        // Add logic to decide if the property should be omitted when empty
        return false;
    }
}