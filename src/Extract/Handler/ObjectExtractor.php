<?php

namespace OneMoreAngle\Marshaller\Extract\Handler;

use OneMoreAngle\Marshaller\Data\IntermediaryData;
use OneMoreAngle\Marshaller\Exception\CircularReferenceException;
use OneMoreAngle\Marshaller\Extract\CircularReferenceDetectWrapper;
use OneMoreAngle\Marshaller\Extract\ExtractionManager;
use OneMoreAngle\Marshaller\Extract\Extractor;
use OneMoreAngle\Marshaller\Typing\TypeToken;
use OneMoreAngle\Marshaller\Typing\TypeTokenFactory;
use ReflectionClass;
use SplObjectStorage;
use stdClass;

class ObjectExtractor implements Extractor {
    protected ExtractionManager $extractionManager;
    protected CircularReferenceDetectWrapper $circularRefCheck;

    public function __construct(ExtractionManager $extractionManager) {
        $this->extractionManager = $extractionManager;
        $this->circularRefCheck = new CircularReferenceDetectWrapper();
    }

    /**
     * @param $data
     * @param TypeToken $token
     * @return IntermediaryData
     * @throws CircularReferenceException
     */
    public function extract($data, TypeToken $token): IntermediaryData {
        return $this->circularRefCheck->execute($data, fn() => $this->extractData($data, $token));
    }

    public function extractData(object $data, TypeToken $token): IntermediaryData {
        if($data instanceof stdClass) {
            // We take on the responsibility of extracting stdClass by creating an array from it and delegating
            // it to the array extractor; there is nothing contextually meaningful to extract from stdClass
            return $this->extractionManager->getArrayExtractor()->extract((array) $data, TypeTokenFactory::array());
        }

        $reflection = new ReflectionClass($data);

        $result = [];
        foreach ($reflection->getProperties() as $property) {
            // TODO: use stage to extract metadata from property to influence the process
            $property->setAccessible(true);
            $value = $property->getValue($data);
            $propertyName = $property->getName();
            $result[$propertyName] = $this->extractionManager->extract($value);
        }

        return new IntermediaryData($result, $token);
    }
}