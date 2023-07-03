<?php

namespace OneMoreAngle\Marshaller\Inject\Handler;

use Exception;
use OneMoreAngle\Marshaller\Data\IntermediaryData;
use OneMoreAngle\Marshaller\Exception\UnresolvedTargetTypeException;
use OneMoreAngle\Marshaller\Inject\InjectionManager;
use OneMoreAngle\Marshaller\Inject\Injector;
use OneMoreAngle\Marshaller\Meta\PropertyMetadataProvider;
use OneMoreAngle\Marshaller\Typing\TypeToken;
use ReflectionClass;
use ReflectionException;

/**
 * @template R of object
 * @implements Injector<R>
 */
class ObjectInjector implements Injector {
    protected InjectionManager $injectorManager;
    protected PropertyMetadataProvider $propertyMetadataProvider;

    /**
     * @param InjectionManager $injectorManager
     * @param PropertyMetadataProvider $propertyMetadataProvider
     */
    public function __construct(InjectionManager $injectorManager, PropertyMetadataProvider $propertyMetadataProvider) {
        $this->injectorManager = $injectorManager;
        $this->propertyMetadataProvider = $propertyMetadataProvider;
    }

    /**
     * @param IntermediaryData<IntermediaryData[]> $data
     * @param TypeToken $token
     * @return mixed the deserialized data which is an instance of the class passed in the constructor
     * @throws ReflectionException|UnresolvedTargetTypeException
     */
    public function reconstruct(IntermediaryData $data, TypeToken $token) {
        if($data->getValue() === null) {
            // This shouldn't ever happen because of the type system, null values should be delegated to the primitive injector
            throw new Exception("Cannot deserialize null into object, invalid state");
        }

        // TODO: more robust class instantiation
        $class = $token->key();
        $object = new $class();
        $reflection = new ReflectionClass($object);

        foreach($data->getValue() as $propertyName => $propertyValue) {
            // TODO: get property name where alias or name is equal to $propertyName
            $reflectionProperty = $reflection->getProperty($propertyName);
            $reflectionProperty->setAccessible(true);
            $typeToken = $this->propertyMetadataProvider->getTargetType($reflectionProperty);

            if($typeToken === null) {
                throw new UnresolvedTargetTypeException("Could not resolve target type for property $propertyName in class $class");
            }

            $deserializer = $this->injectorManager->create($typeToken);
            $reflectionProperty->setValue($object, $deserializer->reconstruct($propertyValue, $typeToken));
        }

        return $object;
    }
}