<?php

namespace OneMoreAngle\Marshaller\Typing;

use OneMoreAngle\Marshaller\Exception\UnsupportedValueException;

class TypeTokenFactory {
    public static function int() : PrimitiveTypeToken {
        return PrimitiveTypeToken::create(TypeToken::INT);
    }

    public static function string() : PrimitiveTypeToken {
        return PrimitiveTypeToken::create(TypeToken::STRING);
    }

    public static function bool() : PrimitiveTypeToken {
        return PrimitiveTypeToken::create(TypeToken::BOOL);
    }

    public static function float() : PrimitiveTypeToken {
        return PrimitiveTypeToken::create(TypeToken::FLOAT);
    }

    public static function object(string $class) : ClassTypeToken {
        return ClassTypeToken::create($class);
    }

    public static function array() : ArrayTypeToken {
        return ArrayTypeToken::create();
    }

    public static function null() : PrimitiveTypeToken {
        return PrimitiveTypeToken::create(TypeToken::NULL);
    }

    public static function tokenize($value) : TypeToken {
        $type = gettype($value);

        if($type === 'object') {
            return self::object(get_class($value));
        }

        return self::fromType($type);
    }

    public static function fromType(string $type) : TypeToken {
        $map = [
            'integer' => fn () => self::int(),
            'string' => fn () => self::string(),
            'boolean' => fn () => self::bool(),
            'float' => fn () => self::float(),
            'double' => fn () => self::float(),
            'NULL' => fn () => self::null(),
            'array' => fn () => self::array(),
        ];

        if (!array_key_exists($type, $map)) {
            throw new UnsupportedValueException("Unsupported type: $type");
        }

        return $map[$type]();
    }

    public static function fromNamedType(string $type) : TypeToken {
        $map = [
            'int' => fn () => self::int(),
            'string' => fn () => self::string(),
            'bool' => fn () => self::bool(),
            'float' => fn () => self::float(),
            'array' => fn () => self::array(),
        ];

        if (array_key_exists($type, $map)) {
            return $map[$type]();
        }

        if (class_exists($type)) {
            return self::object($type);
        }

        throw new UnsupportedValueException("Unsupported type: $type");
    }
}