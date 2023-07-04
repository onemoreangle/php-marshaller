<?php

namespace OneMoreAngle\Marshaller\Serialization\Codecs;

use OneMoreAngle\Marshaller\Data\IntermediaryData;
use OneMoreAngle\Marshaller\Serialization\SerializationVisitor;

class JsonCodec implements SerializationVisitor {

    public function serialize(IntermediaryData $data) {
        $rawData = $data->flatten();
        return json_encode($rawData);
    }

    public function deserialize(string $input): IntermediaryData {
        $rawData = json_decode($input, true);
        return IntermediaryData::build($rawData);
    }
}