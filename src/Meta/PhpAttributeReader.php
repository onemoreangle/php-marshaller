<?php
namespace OneMoreAngle\Marshaller\Meta;

use Exception;
use OneMoreAngle\Marshaller\Attribute\Aliases;
use OneMoreAngle\Marshaller\Attribute\Name;
use OneMoreAngle\Marshaller\Attribute\OmitEmpty;
use OneMoreAngle\Marshaller\Attribute\TargetType;
use OneMoreAngle\Marshaller\Typing\TypeToken;
use OneMoreAngle\Marshaller\Typing\TypeTokenFactory;
use ReflectionNamedType;
use ReflectionProperty;

class PhpAttributeReader implements PropertyMetadataProvider {

    public function getSerializationName(ReflectionProperty $property): ?string {
        $annotation = static::getAttributeForClass($property, Name::class);
        return $annotation ? $annotation->name : null;
    }

    public function getSerializationAliases(ReflectionProperty $property): array {
        $annotation = static::getAttributeForClass($property, Aliases::class);
        return $annotation ? $annotation->names : [];
    }

    public function getTargetType(ReflectionProperty $property): ?TypeToken {
        $annotation = static::getAttributeForClass($property, TargetType::class);

        return $annotation ? TypeTokenFactory::fromNamedType($annotation->type) : null;
    }

    public function isOmitEmpty(ReflectionProperty $property): ?bool {
        $annotation = static::getAttributeForClass($property, OmitEmpty::class);
        return $annotation ? $annotation->omit : null;
    }

    /**
     * @template T
     * @param ReflectionProperty $property
     * @param class-string<T> $attributeClass
     * @return T|null
     * @throws Exception
     */
    protected static function getAttributeForClass(ReflectionProperty $property, string $attributeClass) {
        if (!version_compare(PHP_VERSION, '8.0.0', '>=')) {
            throw new Exception('PHP 8.0.0 or higher is required to use PhpAttributeReader');
        }

        $attributes = $property->getAttributes($attributeClass);
        return $attributes ? $attributes[0]->newInstance() : null;
    }
}
