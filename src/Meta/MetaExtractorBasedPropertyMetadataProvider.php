<?php

namespace OneMoreAngle\Marshaller\Meta;

use OneMoreAngle\Marshaller\Attribute\Aliases;
use OneMoreAngle\Marshaller\Attribute\Name;
use OneMoreAngle\Marshaller\Attribute\Omit;
use OneMoreAngle\Marshaller\Attribute\OmitEmpty;
use OneMoreAngle\Marshaller\Attribute\TargetType;
use OneMoreAngle\Marshaller\Typing\TypeToken;
use OneMoreAngle\Marshaller\Typing\TypeTokenFactory;
use ReflectionProperty;

class MetaExtractorBasedPropertyMetadataProvider implements PropertyMetadataProvider {
    private MetaExtractor $extractor;

    public function __construct(MetaExtractor $extractor) {
        $this->extractor = $extractor;
    }

    public function getSerializationName(ReflectionProperty $property): ?string {
        $annotation = $this->extractor->extractFromProperty($property, Name::class);
        return $annotation ? $annotation->name : null;
    }

    public function getSerializationAliases(ReflectionProperty $property): array {
        $annotation = $this->extractor->extractFromProperty($property, Aliases::class);
        return $annotation ? $annotation->names : [];
    }

    public function getTargetType(ReflectionProperty $property): ?TypeToken {
        $annotation = $this->extractor->extractFromProperty($property, TargetType::class);
        return $annotation ? TypeTokenFactory::fromNamedType($annotation->type) : null;
    }

    public function isOmitEmpty(ReflectionProperty $property): ?bool {
        $annotation = $this->extractor->extractFromProperty($property, OmitEmpty::class);
        return $annotation ? true : null;
    }

    public function isOmit(ReflectionProperty $property): ?bool {
        $annotation = $this->extractor->extractFromProperty($property, Omit::class);
        return $annotation ? true : null;
    }
}
