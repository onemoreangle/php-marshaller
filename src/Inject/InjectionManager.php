<?php

namespace OneMoreAngle\Marshaller\Inject;

use OneMoreAngle\Marshaller\Data\IntermediaryData;
use OneMoreAngle\Marshaller\Inject\Handler\ArrayInjector;
use OneMoreAngle\Marshaller\Inject\Handler\ObjectInjector;
use OneMoreAngle\Marshaller\Inject\Handler\PrimitiveInjector;
use OneMoreAngle\Marshaller\Meta\MetaExtractor;
use OneMoreAngle\Marshaller\Meta\PropertyMetadataProvider;
use OneMoreAngle\Marshaller\Typing\TypeToken;

class InjectionManager implements TypeInjectorProvider, InjectionProcess {
    protected MetaExtractor $metaExtractor;
    protected PropertyMetadataProvider $propertyMetadataProvider;
    private PrimitiveInjector $primitiveInjector;
    private ObjectInjector $objectInjector;
    private ArrayInjector $arrayInjector;

    public function __construct(MetaExtractor $metaExtractor, PropertyMetadataProvider $propertyMetadataProvider, ?PrimitiveInjector $primitiveInjector = null, ?ObjectInjector $objectInjector = null, ?ArrayInjector $arrayInjector = null) {
        $this->metaExtractor = $metaExtractor;
        $this->propertyMetadataProvider = $propertyMetadataProvider;
        $this->primitiveInjector = $primitiveInjector ?? new PrimitiveInjector();
        $this->objectInjector = $objectInjector ?? new ObjectInjector($this, $this->propertyMetadataProvider);
        $this->arrayInjector = $arrayInjector ?? new ArrayInjector($this);
    }

    public function create(TypeToken $typeToken) : Injector {
        return $typeToken->getInjector($this);
    }

    public function getPrimitiveInjector() : Injector {
        return $this->primitiveInjector;
    }

    public function getObjectInjector() : Injector {
        return $this->objectInjector;
    }

    public function getArrayInjector() : Injector {
        return $this->arrayInjector;
    }

    public function reconstruct(IntermediaryData $data, TypeToken $token) {
        return $this->create($token)->reconstruct($data, $token);
    }

    public function getPropertyMetadataProvider() : PropertyMetadataProvider {
        return $this->propertyMetadataProvider;
    }

    public function getMetaExtractor() : MetaExtractor {
        return $this->metaExtractor;
    }
}