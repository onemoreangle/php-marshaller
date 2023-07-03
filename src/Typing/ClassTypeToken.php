<?php

namespace OneMoreAngle\Marshaller\Typing;

use OneMoreAngle\Marshaller\Data\IntermediaryData;
use OneMoreAngle\Marshaller\Extract\Extractor;
use OneMoreAngle\Marshaller\Extract\TypeExtractorProvider;
use OneMoreAngle\Marshaller\Inject\Injector;
use OneMoreAngle\Marshaller\Inject\TypeInjectorProvider;

class ClassTypeToken extends TypeToken {

    /**
     * @var ClassTypeToken[]
     */
    protected static array $instanceCache = [];

    private string $class;

    public static function create(string $class): ClassTypeToken {
        if (!isset(static::$instanceCache[$class])) {
            static::$instanceCache[$class] = new ClassTypeToken($class);
        }

        return static::$instanceCache[$class];
    }

    protected function __construct(string $class) {
        parent::__construct(TypeToken::OBJECT);
        $this->class = $class;
    }

    public function getClass(): string {
        return $this->class;
    }

    public function getExtractor(TypeExtractorProvider $visitable): Extractor {
        return $visitable->getObjectExtractor();
    }

    public function getInjector(TypeInjectorProvider $visitable): Injector {
        return $visitable->getObjectInjector();
    }

    public function visit(TypeVisitor $visitable, IntermediaryData $data): void {
        $visitable->visitObject($data);
    }

    public function key(): string {
        return $this->class;
    }
}