<?php

namespace OneMoreAngle\Marshaller\Data;

use OneMoreAngle\Marshaller\Typing\TypeToken;
use OneMoreAngle\Marshaller\Typing\TypeTokenFactory;

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
    public final function __construct($value, TypeToken $token, ?ExtractionMetaData $metadata = null) {
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

    /**
     * @param ExtractionMetaData|null $metadata
     */
    public function setMetadata(?ExtractionMetaData $metadata): void {
        $this->metadata = $metadata;
    }

    /**
     * @return TypeToken
     */
    public function getType(): TypeToken {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function flatten() {
        if (is_array($this->value)) {
            return array_map(function ($item) {
                return $item instanceof self ? $item->flatten() : $item;
            }, $this->value);
        }

        return $this->value;
    }

    /**
     * @param mixed $data
     */
    public static function build($data): IntermediaryData {
        if (is_array($data)) {
            return new static(
                array_map([static::class, 'build'], $data),
                TypeTokenFactory::array()
            );
        } else {
            return new static(
                $data,
                TypeTokenFactory::tokenize($data)
            );
        }
    }
}