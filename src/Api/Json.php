<?php
namespace OneMoreAngle\Marshaller\Api;

use Exception;
use OneMoreAngle\Marshaller\Exception\CircularReferenceException;
use OneMoreAngle\Marshaller\Serialization\Codecs\JsonCodec;
use OneMoreAngle\Marshaller\Typing\TypeToken;
use OneMoreAngle\Marshaller\Typing\TypeTokenFactory;

class Json {
    private static Serializer $serializer;

    /**
     * @throws Exception
     */
    public static function getSerializer(): Serializer {
        if(!isset(self::$serializer)) {
            self::$serializer = static::default()->build();
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
     * @param $data
     * @param TypeToken|class-string<T> $token
     * @return mixed|T
     * @throws Exception
     */
    public static function unmarshall($data, $token) {
        if(!is_a($token, TypeToken::class)) {
            $token = TypeTokenFactory::object($token);
        }

        return self::getSerializer()->unmarshall($data, $token);
    }

    public static function default(): SerializerBuilder {
        return (new SerializerBuilder())->withCodec(new JsonCodec());
    }
}
