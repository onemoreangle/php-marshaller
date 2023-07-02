<?php

namespace OneMoreAngle\Marshaller\Serialization\Codecs;

use OneMoreAngle\Marshaller\Data\IntermediaryData;
use OneMoreAngle\Marshaller\Serialization\SerializationVisitor;
use OneMoreAngle\Marshaller\Typing\TypeTokenFactory;

class JsonCodec implements SerializationVisitor {

    public function serialize(IntermediaryData $data) {
        $rawData = $this->flatten($data);
        return json_encode($rawData);
    }

    private function flatten($data) {
        if ($data instanceof IntermediaryData) {
            return $this->flatten($data->getValue());
        } elseif (is_array($data)) {
            return array_map([$this, 'flatten'], $data);
        } else {
            return $data;
        }
    }

    public function deserialize($input): IntermediaryData {
        $rawData = json_decode($input, true);
        return $this->constructIntermediaryData($rawData);
    }

    private function constructIntermediaryData($data): IntermediaryData {
        if (is_array($data)) {
            return new IntermediaryData(
                array_map([$this, 'constructIntermediaryData'], $data),
                TypeTokenFactory::array()
            );
        } else {
            return new IntermediaryData(
                $data,
                TypeTokenFactory::tokenize($data)
            );
        }
    }
}