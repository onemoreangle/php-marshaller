<?php

namespace OneMoreAngle\Marshaller\Meta;

use OneMoreAngle\Marshaller\Exception\UnresolvedTargetTypeException;
use OneMoreAngle\Marshaller\Typing\TypeToken;
use OneMoreAngle\Marshaller\Typing\TypeTokenFactory;
use ReflectionNamedType;
use ReflectionProperty;
use Symfony\Component\TypeInfo\Type\CollectionType;
use Symfony\Component\TypeInfo\Type\ObjectType;
use Symfony\Component\TypeInfo\TypeIdentifier;
use Symfony\Component\TypeInfo\TypeResolver\TypeResolver;

class ReflectionPropertyMetadataProvider implements PropertyMetadataProvider {

    protected TypeResolver $resolver;

    public function __construct() {
        $this->resolver = TypeResolver::create();
    }

    public function getSerializationName(ReflectionProperty $property): ?string {
        return $property->getName();
    }

    /**
     * @param ReflectionProperty $property
     * @return string[]
     */
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

        $resolved = $this->resolver->resolve($property);

        /** @var $resolved CollectionType */
        if(
            $resolved->isIdentifiedBy(TypeIdentifier::ARRAY) &&
            $resolved instanceof CollectionType &&
            ($elemType = $resolved->getCollectionValueType())->isIdentifiedBy(TypeIdentifier::OBJECT) &&
            $elemType instanceof ObjectType
        ) {
            // We can't represent this through named types, create a new type token
            return TypeTokenFactory::array(TypeTokenFactory::object($elemType->getClassName()));
        }

        return TypeTokenFactory::fromNamedType($type->getName());
    }

    public function isOmitEmpty(ReflectionProperty $property): ?bool {
        return null;
    }


    public function isOmit(ReflectionProperty $property): ?bool {
        return null;
    }
}