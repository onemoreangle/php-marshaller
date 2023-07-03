<?php

namespace OneMoreAngle\Marshaller\Typing;

use OneMoreAngle\Marshaller\Data\IntermediaryData;
use OneMoreAngle\Marshaller\Extract\Extractor;
use OneMoreAngle\Marshaller\Extract\TypeExtractorProvider;
use OneMoreAngle\Marshaller\Inject\Injector;
use OneMoreAngle\Marshaller\Inject\TypeInjectorProvider;

class PrimitiveTypeToken extends TypeToken {

    /**
     * @var PrimitiveTypeToken[]
     */
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

    public function getExtractor(TypeExtractorProvider $visitable): Extractor {
        return $visitable->getPrimitiveExtractor();
    }

    public function getInjector(TypeInjectorProvider $visitable): Injector {
        return $visitable->getPrimitiveInjector();
    }

    public function visit(TypeVisitor $visitable, IntermediaryData $data): void {
        $visitable->visitPrimitive($data);
    }

    public function key(): string {
        return $this->type;
    }
}