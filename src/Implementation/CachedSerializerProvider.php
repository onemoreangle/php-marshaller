<?php

namespace OneMoreAngle\Marshaller\Implementation;

use Exception;
use OneMoreAngle\Marshaller\Api\Serializer;
use OneMoreAngle\Marshaller\Exception\CircularReferenceException;
use OneMoreAngle\Marshaller\Typing\TypeToken;
use OneMoreAngle\Marshaller\Typing\TypeTokenFactory;

abstract class CachedSerializerProvider implements SerializationProvider {

    /**
     * @var array<class-string<static>, Serializer> $cache
     */
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
    public static function marshal($value) {
        return static::getSerializer()->marshal($value);
    }

    /**
     * @template T
     * @param string $data
     * @param TypeToken|class-string<T> $token
     * @return mixed|T
     * @throws Exception
     */
    public static function unmarshal($data, $token) {
        return static::getSerializer()->unmarshal($data, $token);
    }
}