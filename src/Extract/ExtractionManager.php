<?php

namespace OneMoreAngle\Marshaller\Extract;

use OneMoreAngle\Marshaller\Data\Serializable;
use OneMoreAngle\Marshaller\Exception\CircularReferenceException;
use OneMoreAngle\Marshaller\Extract\Handler\ArrayExtractor;
use OneMoreAngle\Marshaller\Extract\Handler\ObjectExtractor;
use OneMoreAngle\Marshaller\Extract\Handler\PrimitiveExtractor;
use OneMoreAngle\Marshaller\Typing\TypeTokenFactory;

class ExtractionManager implements ExtractorProcess {
    private PrimitiveExtractor $primitiveHandler;
    private ObjectExtractor $objectHandler;
    private ArrayExtractor $arrayHandler;

    public function __construct($primitiveHandler = null, $objectHandler = null, $arrayHandler = null) {
        $this->primitiveHandler = $primitiveHandler ?? new PrimitiveExtractor();
        $this->objectHandler = $objectHandler ?? new ObjectExtractor($this);
        $this->arrayHandler = $arrayHandler ?? new ArrayExtractor($this);
    }

    /**
     * @throws CircularReferenceException
     */
    public function extract($data) : Serializable {
        $typeToken = TypeTokenFactory::tokenize($data);
        $serializer = $typeToken->getExtractor($this);
        return $serializer->extract($data);
    }


    public function getPrimitiveExtractor() : Extractor {
        return $this->primitiveHandler;
    }

    public function getObjectExtractor() : Extractor {
        return $this->objectHandler;
    }

    public function getArrayExtractor() : Extractor {
        return $this->arrayHandler;
    }
}