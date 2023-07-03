<?php

namespace OneMoreAngle\Marshaller\Implementation;

use Exception;
use OneMoreAngle\Marshaller\Api\Serializer;
use OneMoreAngle\Marshaller\Exception\CircularReferenceException;
use OneMoreAngle\Marshaller\Typing\TypeToken;
use OneMoreAngle\Marshaller\Typing\TypeTokenFactory;

abstract class CachedSerializerProvider implements SerializationProvider {

    /** @var Serializer[] */
    private static array $cache;

    /**
     * @throws Exception
     */
    protected static function getSerializer(): Serializer {
        $cid = static::class;
        if(!isset(self::$cache[$cid])) {
            self::$cache[$cid] = static::getDefaultSerializerBuilder()->build();
        }
        return self::$cache[$cid];
    }

    /**
     * @param mixed $value
     * @throws CircularReferenceException
     * @throws Exception
     * @return string|false
     */
    public static function marshall($value) {
        return static::getSerializer()->marshall($value);
    }

    /**
     * @template T
     * @param $data
     * @param TypeToken|class-string<T> $token
     * @return mixed|T
     * @throws Exception
     */
    public static function unmarshall($data, $token) {
        if(is_string($token)) {
            $token = TypeTokenFactory::object($token);
        } else if(!is_a($token, TypeToken::class)) {
            throw new Exception("Invalid token type, expected class string or TypeToken");
        }

        return static::getSerializer()->unmarshall($data, $token);
    }
}