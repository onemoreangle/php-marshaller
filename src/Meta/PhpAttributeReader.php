<?php
namespace OneMoreAngle\Marshaller\Meta;

use Exception;
use OneMoreAngle\Marshaller\Attribute\Aliases;
use OneMoreAngle\Marshaller\Attribute\Name;
use OneMoreAngle\Marshaller\Typing\TargetType;
use OneMoreAngle\Marshaller\Typing\TypeToken;
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
        $attributes = $property->getAttributes(TargetType::class);
        $rawType = $attributes && $attributes[0]->newInstance()->type;
        return $rawType ? new TypeTok : null;
    }

    public function isOmitEmpty(ReflectionProperty $property): ?bool {
        // TODO: Implement isOmitEmpty() method.
    }
}
