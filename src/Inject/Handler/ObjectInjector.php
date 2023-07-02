<?php

namespace OneMoreAngle\Marshaller\Inject\Handler;

use OneMoreAngle\Marshaller\Data\IntermediaryData;
use OneMoreAngle\Marshaller\Inject\InjectorManager;
use OneMoreAngle\Marshaller\Inject\Injector;
use OneMoreAngle\Marshaller\Meta\PropertyMetadataProvider;
use OneMoreAngle\Marshaller\Typing\TypeToken;
use ReflectionClass;
use ReflectionException;

/**
 * @template R of object
 * @implements Injector<array, R>
 */
class ObjectInjector implements Injector {
    protected InjectorManager $injectorManager;
    protected PropertyMetadataProvider $propertyMetadataProvider;

    /**
     * @param InjectorManager $injectorManager
     */
    public function __construct(InjectorManager $injectorManager, PropertyMetadataProvider $propertyMetadataProvider) {
        $this->injectorManager = $injectorManager;
        $this->propertyMetadataProvider = $propertyMetadataProvider;
    }

    /**
     * @param IntermediaryData $data
     * @param TypeToken $token
     * @return R the deserialized data which is an instance of the class passed in the constructor
     * @throws ReflectionException
     */
    public function reconstruct(IntermediaryData $data, TypeToken $token) {
        // TODO: more robust class instantiation
        $class = $token->key();
        $object = new $class();
        $reflection = new ReflectionClass($object);

        foreach ($data as $propertyName => $propertyValue) {
            // TODO: get property name where alias or name is equal to $propertyName
            $reflectionProperty = $reflection->getProperty($propertyName);
            $reflectionProperty->setAccessible(true);
            $typeToken = $this->propertyMetadataProvider->getTargetType($reflectionProperty);
            $deserializer = $this->injectorManager->create($typeToken);
            $reflectionProperty->setValue($object, $deserializer->reconstruct($propertyValue, $typeToken));
        }

        return $object;
    }
}