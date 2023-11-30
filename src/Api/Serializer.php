<?php

namespace OneMoreAngle\Marshaller\Api;

use Exception;
use OneMoreAngle\Marshaller\Exception\CircularReferenceException;
use OneMoreAngle\Marshaller\Extract\ExtractionProcess;
use OneMoreAngle\Marshaller\Inject\InjectionProcess;
use OneMoreAngle\Marshaller\Serialization\SerializationVisitor;
use OneMoreAngle\Marshaller\Typing\TypeToken;
use OneMoreAngle\Marshaller\Typing\TypeTokenFactory;

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
     * @template T
     * @param string $data
     * @param TypeToken|class-string<T> $token
     * @return mixed|T
     * @throws Exception
     */
    public function unmarshal(string $data, $token) {
        if(is_string($token)) {
            $token = TypeTokenFactory::object($token);
        } else if(!is_a($token, TypeToken::class)) {
            throw new Exception("Invalid token type, expected class string or TypeToken");
        }

        $data = $this->codec->deserialize($data);
        return $this->injectionProcess->reconstruct($data, $token);
    }
}