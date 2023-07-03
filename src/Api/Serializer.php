<?php

namespace OneMoreAngle\Marshaller\Api;

use OneMoreAngle\Marshaller\Exception\CircularReferenceException;
use OneMoreAngle\Marshaller\Extract\ExtractionProcess;
use OneMoreAngle\Marshaller\Inject\InjectionProcess;
use OneMoreAngle\Marshaller\Serialization\SerializationVisitor;
use OneMoreAngle\Marshaller\Typing\TypeToken;

class Serializer {
    private ExtractionProcess $extractionProcess;
    private InjectionProcess $injectionProcess;
    private SerializationVisitor $codec;

    public function __construct(ExtractionProcess $extractionProcess, InjectionProcess $injectionProcess, SerializationVisitor $codec) {
        $this->extractionProcess = $extractionProcess;
        $this->injectionProcess = $injectionProcess;
        $this->codec = $codec;
    }

    /**
     * @param mixed $value
     * @throws CircularReferenceException
     * @return string|false
     */
    public function marshal($value) {
        $extracted = $this->extractionProcess->extract($value);
        return $this->codec->serialize($extracted);
    }

    /**
     * @param string $data
     * @param TypeToken $token
     * @return mixed
     */
    public function unmarshal(string $data, TypeToken $token) {
        $data = $this->codec->deserialize($data);
        return $this->injectionProcess->reconstruct($data, $token);
    }
}