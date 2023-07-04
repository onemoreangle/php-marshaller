<?php
namespace OneMoreAngle\Marshaller\Api;

use OneMoreAngle\Marshaller\Implementation\CachedSerializerProvider;
use OneMoreAngle\Marshaller\Serialization\Codecs\YamlCodec;

class Yaml extends CachedSerializerProvider {

    public static function getDefaultSerializerBuilder(): SerializerBuilder {
        return (new SerializerBuilder())->withCodec(new YamlCodec());
    }

}
