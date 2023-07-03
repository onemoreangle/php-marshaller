<?php
namespace OneMoreAngle\Marshaller\Api;

use Exception;
use OneMoreAngle\Marshaller\Exception\CircularReferenceException;
use OneMoreAngle\Marshaller\Serialization\Codecs\JsonCodec;

class Json {
    private static Serializer $serializer;

    /**
     * @throws Exception
     */
    public static function getSerializer(): Serializer {
        if(!isset(self::$serializer)) {
            self::$serializer = (new SerializerBuilder())->withCodec(new JsonCodec())->build();
        }
        return self::$serializer;
    }

    /**
     * @param mixed $value
     * @throws CircularReferenceException
     * @throws Exception
     */
    public static function marshall($value) {
        return self::getSerializer()->marshall($value);
    }

    /**
     * @template T
     * @param class-string<T> $class
     * @return T
     * @throws Exception
     */
    public static function unmarshall($data, string $class) {
        return self::getSerializer()->unmarshall($data, $class);
    }

    public static function customize(): SerializerBuilder {
        return new SerializerBuilder();
    }
}
