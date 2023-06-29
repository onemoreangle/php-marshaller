<?php
namespace OneMoreAngle\Marshaller\Annotation;

use ReflectionProperty;

interface PropertyMetaReader {
    public function getJsonName(ReflectionProperty $property): ?string;
    public function getOmitEmpty(ReflectionProperty $property): ?bool;

}