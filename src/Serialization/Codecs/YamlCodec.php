<?php

namespace OneMoreAngle\Marshaller\Serialization\Codecs;

use OneMoreAngle\Marshaller\Data\IntermediaryData;
use OneMoreAngle\Marshaller\Serialization\SerializationVisitor;

class YamlCodec implements SerializationVisitor {

    public function __construct() {
        if (!class_exists('Symfony\Component\Yaml\Yaml')) {
            throw new \RuntimeException('The Symfony YAML component is not installed. Please install it with `composer require symfony/yaml`.');
        }
    }

    public function serialize(IntermediaryData $data) {
        $rawData = $data->flatten();
        return \Symfony\Component\Yaml\Yaml::dump($rawData);
    }

    public function deserialize(string $input): IntermediaryData {
        $rawData = \Symfony\Component\Yaml\Yaml::parse($input);
        return IntermediaryData::build($rawData);
    }
}