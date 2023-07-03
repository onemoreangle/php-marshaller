<?php

namespace OneMoreAngle\Marshaller\Data;

use OneMoreAngle\Marshaller\Typing\TypeToken;

/**
 * @template T
 */
class IntermediaryData {
    /** @var T|null $value */
    protected $value;
    protected TypeToken $type;
    private ?ExtractionMetaData $metadata;

    /**
     * @param T $value
     * @param TypeToken $token
     * @param ExtractionMetaData|null $metadata
     */
    public function __construct($value, TypeToken $token, ExtractionMetaData $metadata = null) {
        $this->value = $value;
        $this->type = $token;
        $this->metadata = $metadata;
    }

    /**
     * @return T|null
     */
    public function getValue() {
        return $this->value;
    }

    public function getMetadata(): ?ExtractionMetaData {
        return $this->metadata;
    }
}