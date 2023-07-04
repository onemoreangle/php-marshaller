<?php

namespace OneMoreAngle\Marshaller\Extract;

use OneMoreAngle\Marshaller\Data\IntermediaryData;
use OneMoreAngle\Marshaller\Exception\CircularReferenceException;
use OneMoreAngle\Marshaller\Extract\Handler\ArrayExtractor;
use OneMoreAngle\Marshaller\Extract\Handler\ObjectExtractor;
use OneMoreAngle\Marshaller\Extract\Handler\PrimitiveExtractor;
use OneMoreAngle\Marshaller\Meta\MetaExtractor;
use OneMoreAngle\Marshaller\Meta\PropertyMetadataProvider;
use OneMoreAngle\Marshaller\Typing\TypeTokenFactory;

class ExtractionManager implements TypeExtractorProvider, ExtractionProcess {
    private MetaExtractor $metaExtractor;
    private PropertyMetadataProvider $propertyMetadataProvider;
    private PrimitiveExtractor $primitiveExtractor;
    private ObjectExtractor $objectExtractor;
    private ArrayExtractor $arrayExtractor;

    public function __construct(MetaExtractor $metaExtractor, PropertyMetadataProvider $propertyMetadataProvider, PrimitiveExtractor $primitiveExtractor = null, ObjectExtractor $objectExtractor = null, ArrayExtractor $arrayExtractor = null) {
        $this->metaExtractor = $metaExtractor;
        $this->propertyMetadataProvider = $propertyMetadataProvider;
        $this->primitiveExtractor = $primitiveExtractor ?? new PrimitiveExtractor();
        $this->objectExtractor = $objectExtractor ?? new ObjectExtractor($this);
        $this->arrayExtractor = $arrayExtractor ?? new ArrayExtractor($this);
    }

    /**
     * @throws CircularReferenceException
     */
    public function extract($data) : IntermediaryData {
        $typeToken = TypeTokenFactory::tokenize($data);
        $extractor = $typeToken->getExtractor($this);
        return $extractor->extract($data, $typeToken);
    }


    public function getPrimitiveExtractor() : Extractor {
        return $this->primitiveExtractor;
    }

    public function getObjectExtractor() : Extractor {
        return $this->objectExtractor;
    }

    public function getArrayExtractor() : Extractor {
        return $this->arrayExtractor;
    }

    public function getPropertyMetadataProvider() : PropertyMetadataProvider {
        return $this->propertyMetadataProvider;
    }

    public function getMetaExtractor() : MetaExtractor {
        return $this->metaExtractor;
    }
}