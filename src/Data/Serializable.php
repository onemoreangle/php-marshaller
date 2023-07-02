<?php

namespace OneMoreAngle\Marshaller\Data;

/**
 * @package OneMoreAngle\Marshaller\Data
 * An intermediary data structure that can be directly serialized. This class includes
 * metadata included in the original data structure, so that it can effectively be
 * utilized in the encoding process. Since the reconstruction process already has access
 * to the original data structure, it is not necessary to include this metadata in the
 * intermediary data structure itself. Therefore, we have a separate intermediate data
 * structure which this class extends.
 */
class Serializable extends IntermediaryData {
    private ?ExtractionMetaData $metadata;

    public function __construct($value = null, ExtractionMetaData $metadata = null) {
        parent::__construct($value);
        $this->metadata = $metadata;
    }

    public function getMetadata(): ExtractionMetaData {
        return $this->metadata;
    }
}