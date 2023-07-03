<?php
namespace OneMoreAngle\Marshaller\Api;

use OneMoreAngle\Marshaller\Implementation\CachedSerializerProvider;
use OneMoreAngle\Marshaller\Serialization\Codecs\JsonCodec;

class Json extends CachedSerializerProvider {

    public static function getDefaultSerializerBuilder(): SerializerBuilder {
        return (new SerializerBuilder())->withCodec(new JsonCodec());
    }

}
