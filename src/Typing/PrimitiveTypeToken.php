<?php

namespace OneMoreAngle\Marshaller\Typing;

use OneMoreAngle\Marshaller\Extract\Extractor;
use OneMoreAngle\Marshaller\Extract\ExtractorProcess;
use OneMoreAngle\Marshaller\Inject\Injector;
use OneMoreAngle\Marshaller\Inject\InjectorProcess;

class PrimitiveTypeToken extends TypeToken {

    protected static array $instanceCache = [];

    public static function create(string $type): PrimitiveTypeToken {
        if (!isset(static::$instanceCache[$type])) {
            static::$instanceCache[$type] = new PrimitiveTypeToken($type);
        }

        return static::$instanceCache[$type];
    }

    protected function __construct($type) {
        parent::__construct($type);
    }

    public function getExtractor(ExtractorProcess $visitable): Extractor {
        return $visitable->getPrimitiveExtractor();
    }

    public function getInjector(InjectorProcess $visitable): Injector {
        return $visitable->getPrimitiveInjector();
    }

    public function key(): string {
        return $this->type;
    }
}