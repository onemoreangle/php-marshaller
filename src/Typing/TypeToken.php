<?php

namespace OneMoreAngle\Marshaller\Typing;

use OneMoreAngle\Marshaller\Deserialization\Deserializer;
use OneMoreAngle\Marshaller\Deserialization\DeserializerFactory;
use OneMoreAngle\Marshaller\Serialization\Serializer;
use OneMoreAngle\Marshaller\Serialization\SerializerFactory;

abstract class TypeToken {

    const NULL = "null";
    const ARRAY = "array";
    const BOOL = "boolean";
    const INT = "integer";
    const FLOAT = "float";
    const STRING = "string";
    const OBJECT = "object";

    protected static $TYPES = [
        self::NULL,
        self::ARRAY,
        self::BOOL,
        self::INT,
        self::FLOAT,
        self::STRING,
        self::OBJECT
    ];

    protected string $type;

    protected function __construct($type) {
        $this->type = $type;
    }

    abstract public function getSerializer(SerializerFactory $factory): Serializer;

    abstract public function getDeserializer(DeserializerFactory $factory): Deserializer;
}