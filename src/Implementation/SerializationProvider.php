<?php

namespace OneMoreAngle\Marshaller\Implementation;

use Exception;
use OneMoreAngle\Marshaller\Api\SerializerBuilder;
use OneMoreAngle\Marshaller\Exception\CircularReferenceException;
use OneMoreAngle\Marshaller\Typing\TypeToken;

interface SerializationProvider {

    /**
     * @param mixed $value
     * @throws CircularReferenceException
     * @throws Exception
     * @return string|false
     */
    public static function marshall($value);

    /**
     * @template T
     * @param string $data
     * @param TypeToken|class-string<T> $token
     * @return mixed|T
     * @throws Exception
     */
    public static function unmarshall($data, $token);

    /**
     * @return SerializerBuilder
     */
    public static function getDefaultSerializerBuilder(): SerializerBuilder;
}