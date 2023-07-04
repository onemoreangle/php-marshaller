<?php

namespace OneMoreAngle\Marshaller\Extract\Handler;

use OneMoreAngle\Marshaller\Data\ExtractionMetaData;
use OneMoreAngle\Marshaller\Data\IntermediaryData;
use OneMoreAngle\Marshaller\Exception\CircularReferenceException;
use OneMoreAngle\Marshaller\Exception\UnresolvedPropertyMetaData;
use OneMoreAngle\Marshaller\Extract\CircularReferenceDetectWrapper;
use OneMoreAngle\Marshaller\Extract\ExtractionManager;
use OneMoreAngle\Marshaller\Extract\Extractor;
use OneMoreAngle\Marshaller\Typing\TypeToken;
use OneMoreAngle\Marshaller\Typing\TypeTokenFactory;
use ReflectionClass;
use stdClass;

class ObjectExtractor implements Extractor {
    protected ExtractionManager $extractionManager;
    protected CircularReferenceDetectWrapper $circularRefCheck;

    public function __construct(ExtractionManager $extractionManager) {
        $this->extractionManager = $extractionManager;
        $this->circularRefCheck = new CircularReferenceDetectWrapper();
    }

    /**
     * @param object $data
     * @param TypeToken $token
     * @return IntermediaryData
     * @throws CircularReferenceException|UnresolvedPropertyMetaData
     */
    public function extract($data, TypeToken $token): IntermediaryData {
        return $this->circularRefCheck->execute($data, fn() => $this->extractData($data, $token));
    }

    /**
     * @throws CircularReferenceException
     * @throws UnresolvedPropertyMetaData
     */
    public function extractData(object $data, TypeToken $token): IntermediaryData {
        if($data instanceof stdClass) {
            // We take on the responsibility of extracting stdClass by creating an array from it and delegating
            // it to the array extractor; there is nothing contextually meaningful to extract from stdClass
            return $this->extractionManager->getArrayExtractor()->extract((array) $data, TypeTokenFactory::array());
        }

        $reflection = new ReflectionClass($data);

        $annotations = $this->extractionManager->getMetaExtractor()->extractAllFromClass($reflection);

        $result = [];
        foreach ($reflection->getProperties() as $property) {
            if($this->extractionManager->getPropertyMetadataProvider()->isOmit($property) === true) {
                continue;
            }

            $name = $this->extractionManager->getPropertyMetadataProvider()->getSerializationName($property);
            if($name === null) {
                throw new UnresolvedPropertyMetaData("Could not resolve serialization name for property {$property->getName()} in class {$reflection->getName()} using the configured PropertyMetadataProvider");
            }

            $omitEmpty = $this->extractionManager->getPropertyMetadataProvider()->isOmitEmpty($property);
            $property->setAccessible(true);
            $value = $property->getValue($data);
            if($omitEmpty === true && empty($value)) {
                continue;
            }

            $propertyIntermediateData = $this->extractionManager->extract($value);
            $propertyIntermediateData->setMetadata(new ExtractionMetaData($this->extractionManager->getMetaExtractor()->extractAllFromProperty($property)));
            $result[$name] = $propertyIntermediateData;
        }

        return new IntermediaryData($result, $token, new ExtractionMetaData($annotations));
    }
}