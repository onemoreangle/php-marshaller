<?php

namespace OneMoreAngle\Marshaller\Typing;

use OneMoreAngle\Marshaller\Deserialization\Deserializer;
use OneMoreAngle\Marshaller\Deserialization\DeserializerFactory;
use OneMoreAngle\Marshaller\Serialization\SerializationManager;
use OneMoreAngle\Marshaller\Serialization\Serializer;
use OneMoreAngle\Marshaller\Serialization\Marshaller;

class ClassTypeToken extends TypeToken {

    protected static array $instanceCache = [];

    private string $class;

    public static function create(string $class): ClassTypeToken {
        if (!isset(static::$instanceCache[$class])) {
            static::$instanceCache[$class] = new ClassTypeToken($class);
        }

        return static::$instanceCache[$class];
    }

    protected function __construct(string $class) {
        parent::__construct(TypeToken::OBJECT);
        $this->class = $class;
    }

    public function getClass(): string {
        return $this->class;
    }

    public function getSerializer(SerializationManager $factory): Serializer {
        return $factory->getClassSerializer($this->class);
    }

    public function getDeserializer(DeserializerFactory $factory): Deserializer {
        return $factory->createClassDeserializer($this->class);
    }

    public function key(): string {
        return $this->class;
    }
}