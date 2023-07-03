<?php

namespace OneMoreAngle\Marshaller\Typing;

use OneMoreAngle\Marshaller\Data\IntermediaryData;
use OneMoreAngle\Marshaller\Extract\Extractor;
use OneMoreAngle\Marshaller\Extract\TypeExtractorProvider;
use OneMoreAngle\Marshaller\Inject\Injector;
use OneMoreAngle\Marshaller\Inject\TypeInjectorProvider;

class ArrayTypeToken extends TypeToken {

    protected static ArrayTypeToken $instance;

    protected function __construct() {
        parent::__construct(static::ARRAY);
    }

    public static function create(): ArrayTypeToken {
        if (!isset(static::$instance)) {
            static::$instance = new ArrayTypeToken();
        }

        return static::$instance;
    }

    public function getExtractor(TypeExtractorProvider $visitable): Extractor {
        return $visitable->getArrayExtractor();
    }

    public function getInjector(TypeInjectorProvider $visitable): Injector {
        return $visitable->getArrayInjector();
    }

    public function visit(TypeVisitor $visitable, IntermediaryData $data): void {
        $visitable->visitArray($data);
    }

    public function key(): string {
        return static::ARRAY;
    }
}