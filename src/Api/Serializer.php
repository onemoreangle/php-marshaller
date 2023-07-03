<?php

namespace OneMoreAngle\Marshaller\Api;

use OneMoreAngle\Marshaller\Exception\CircularReferenceException;
use OneMoreAngle\Marshaller\Extract\ExtractionManager;
use OneMoreAngle\Marshaller\Inject\InjectorManager;
use OneMoreAngle\Marshaller\Serialization\Codecs\JsonCodec;
use OneMoreAngle\Marshaller\Serialization\SerializationVisitor;

class Serializer {
    private ExtractionManager $extractionManager;
    private InjectorManager $injectorManager;
    private JsonCodec $codec;

    public function __construct(ExtractionManager $extractionManager, InjectorManager $injectorManager, SerializationVisitor $codec) {
        $this->extractionManager = $extractionManager;
        $this->codec = $codec;
        $this->injectorManager = $injectorManager;
    }

    /**
     * @throws CircularReferenceException
     */
    public function marshall($value) {
        $extracted = $this->extractionManager->extract($value);
        return $this->codec->serialize($extracted);
    }

    public function unmarshall($data, $class) {
        $data = $this->codec->deserialize($data);
        return $this->injectorManager->reconstruct($data, $class);
    }
}