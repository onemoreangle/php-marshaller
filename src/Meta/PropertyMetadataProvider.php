<?php
namespace OneMoreAngle\Marshaller\Meta;

use OneMoreAngle\Marshaller\Typing\TypeToken;
use ReflectionProperty;

interface PropertyMetadataProvider {
    public function getSerializationName(ReflectionProperty $property): ?string;
    public function getSerializationAliases(ReflectionProperty $property): array;
    public function getTargetType(ReflectionProperty $property): ?TypeToken;
    public function isOmitEmpty(ReflectionProperty $property): ?bool;
}