<?php

namespace OneMoreAngle\Marshaller\Api;

use OneMoreAngle\Marshaller\Exception\CircularReferenceException;
use OneMoreAngle\Marshaller\Extract\ExtractionManager;
use OneMoreAngle\Marshaller\Inject\InjectionManager;
use OneMoreAngle\Marshaller\Serialization\SerializationVisitor;
use OneMoreAngle\Marshaller\Typing\TypeToken;

class Serializer {
    private ExtractionManager $extractionManager;
    private InjectionManager $injectionManager;
    private SerializationVisitor $codec;

    public function __construct(ExtractionManager $extractionManager, InjectionManager $injectionManager, SerializationVisitor $codec) {
        $this->extractionManager = $extractionManager;
        $this->codec = $codec;
        $this->injectionManager = $injectionManager;
    }

    /**
     * @throws CircularReferenceException
     */
    public function marshall($value) {
        $extracted = $this->extractionManager->extract($value);
        return $this->codec->serialize($extracted);
    }

    public function unmarshall($data, TypeToken $token) {
        $data = $this->codec->deserialize($data);
        return $this->injectionManager->reconstruct($data, $token);
    }
}