<?php
namespace OneMoreAngle\Marshaller\Meta;

use Exception;
use OneMoreAngle\Marshaller\Attribute\Aliases;
use OneMoreAngle\Marshaller\Attribute\Name;
use OneMoreAngle\Marshaller\Attribute\OmitEmpty;
use OneMoreAngle\Marshaller\Attribute\TargetType;
use OneMoreAngle\Marshaller\Typing\TypeToken;
use OneMoreAngle\Marshaller\Typing\TypeTokenFactory;
use ReflectionProperty;

class PhpAttributeReader implements PropertyMetadataProvider {
    public function __construct() {
        if (version_compare(PHP_VERSION, '8.0.0', '>=')) {
            throw new Exception('PHP 8.0.0 or higher is required');
        }
    }

    public function getSerializationName(ReflectionProperty $property): ?string {
        $attributes = $property->getAttributes(Name::class);
        return $attributes ? $attributes[0]->newInstance()->name : $property->getName();
    }

    public function getSerializationAliases(ReflectionProperty $property): array {
        $attributes = $property->getAttributes(Aliases::class);
        return $attributes ? $attributes[0]->newInstance()->aliases : [];
    }

    public function getTargetType(ReflectionProperty $property): ?TypeToken {
        $annotation = static::getAttributeForClass($property, TargetType::class);
        return $annotation ? TypeTokenFactory::fromNamedType($property->getType()->getName()) : null;
    }

    public function isOmitEmpty(ReflectionProperty $property): ?bool {
        $annotation = static::getAttributeForClass($property, OmitEmpty::class);
        return $annotation ? $annotation->omitEmpty : null;
    }


    /**
     * @template T
     * @param ReflectionProperty $property
     * @param class-string<T> $attributeClass
     * @return T|null
     */
    protected static function getAttributeForClass(ReflectionProperty $property, string $attributeClass) {
        $attributes = $property->getAttributes($attributeClass);
        return $attributes ? $attributes[0]->newInstance() : null;
    }
}
