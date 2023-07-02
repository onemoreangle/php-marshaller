<?php

namespace OneMoreAngle\Marshaller\Data;

use OneMoreAngle\Marshaller\Typing\TypeToken;

class IntermediaryData {
    protected $value;
    protected TypeToken $type;
    private ?ExtractionMetaData $metadata;

    public function __construct($value, TypeToken $token, ExtractionMetaData $metadata = null) {
        $this->value = $value;
        $this->type = $token;
        $this->metadata = $metadata;
    }

    public function getValue() {
        return $this->value;
    }

    public function getMetadata(): ExtractionMetaData {
        return $this->metadata;
    }
}