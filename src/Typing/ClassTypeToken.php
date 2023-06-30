<?php

namespace OneMoreAngle\Marshaller\Typing;

use OneMoreAngle\Marshaller\Deserialization\Deserializer;
use OneMoreAngle\Marshaller\Deserialization\DeserializerFactory;
use OneMoreAngle\Marshaller\Serialization\Serializer;
use OneMoreAngle\Marshaller\Serialization\SerializerFactory;

class ClassTypeToken extends TypeToken {

    private string $class;

    public function __construct(string $class) {
        parent::__construct(TypeToken::OBJECT);
        $this->class = $class;
    }

    public function getClass(): string {
        return $this->class;
    }

    public function getSerializer(SerializerFactory $factory): Serializer {
        return $factory->createClassSerializer($this->class);
    }

    public function getDeserializer(DeserializerFactory $factory): Deserializer {
        return $factory->createClassDeserializer($this->class);
    }
}