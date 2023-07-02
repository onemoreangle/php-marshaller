<?php

namespace OneMoreAngle\Marshaller\Extract\Handler;

use OneMoreAngle\Marshaller\Data\Serializable;
use OneMoreAngle\Marshaller\Exception\CircularReferenceException;
use OneMoreAngle\Marshaller\Extract\CircularReferenceDetectWrapper;
use OneMoreAngle\Marshaller\Extract\ExtractionManager;
use OneMoreAngle\Marshaller\Extract\Extractor;
use ReflectionClass;
use SplObjectStorage;

class ObjectExtractor implements Extractor {
    protected ExtractionManager $marshaller;
    protected CircularReferenceDetectWrapper $circularRefCheck;

    public function __construct(ExtractionManager $marshaller) {
        $this->marshaller = $marshaller;
        $this->circularRefCheck = new CircularReferenceDetectWrapper();
    }

    /**
     * @throws CircularReferenceException
     */
    public function extract($data): Serializable {
        return $this->circularRefCheck->execute($data, fn() => $this->extractData($data));
    }

    public function extractData(object $data): Serializable {
        $reflection = new ReflectionClass($data);
        $result = new Serializable();

        foreach ($reflection->getProperties() as $property) {
            $property->setAccessible(true);
            $value = $property->getValue($data);
            $propertyName = $property->getName();
            // use a stage process to get metadata
            $result[$propertyName] = $this->marshaller->extract($value);
        }
        return $result;
    }
}