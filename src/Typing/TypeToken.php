<?php

namespace OneMoreAngle\Marshaller\Typing;

class TypeToken {

    const ARRAY = "array";
    const BOOL = "boolean";
    const INT = "integer";
    const FLOAT = "float";
    const STRING = "string";
    const OBJECT = "object";

    static $TYPES = [
        self::ARRAY,
        self::BOOL,
        self::INT,
        self::FLOAT,
        self::STRING,
        self::OBJECT
    ];

    private string $type;

    protected function __construct($type) {
        $this->type = $type;
    }

    public function getType(): string {
        return $this->type;
    }
}