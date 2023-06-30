<?php

namespace OneMoreAngle\Marshaller\Typing;

use OneMoreAngle\Marshaller\Exception\UnsupportedValueException;

class TypeTokenFactory {
    public static function int() : PrimitiveTypeToken {
        return new PrimitiveTypeToken(TypeToken::INT);
    }

    public static function string() : PrimitiveTypeToken {
        return new PrimitiveTypeToken(TypeToken::STRING);
    }

    public static function bool() : PrimitiveTypeToken {
        return new PrimitiveTypeToken(TypeToken::BOOL);
    }

    public static function float() : PrimitiveTypeToken {
        return new PrimitiveTypeToken(TypeToken::FLOAT);
    }

    public static function object(string $class) : ClassTypeToken {
        return new ClassTypeToken($class);
    }

    public static function array() : ArrayTypeToken {
        return new ArrayTypeToken();
    }

    public static function null() : PrimitiveTypeToken {
        return new PrimitiveTypeToken(TypeToken::NULL);
    }

    public static function tokenize($value) : TypeToken {
        $type = gettype($value);
        $map = [
            'integer' => fn () => self::int(),
            'string' => fn () => self::string(),
            'boolean' => fn () => self::bool(),
            'double' => fn () => self::float(),
            'NULL' => fn () => self::null(),
            'array' => fn () => self::array(),
            'object' => fn () => self::object(get_class($value))
        ];

        if (!array_key_exists($type, $map)) {
            throw new UnsupportedValueException("Unsupported type: $type");
        }

        return $map[$type]();
    }
}