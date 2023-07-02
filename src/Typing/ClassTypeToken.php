<?php

namespace OneMoreAngle\Marshaller\Typing;

use OneMoreAngle\Marshaller\Extract\Extractor;
use OneMoreAngle\Marshaller\Extract\ExtractorProcess;
use OneMoreAngle\Marshaller\Inject\Injector;
use OneMoreAngle\Marshaller\Inject\InjectorProcess;

class ClassTypeToken extends TypeToken {

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

    public function getExtractor(ExtractorProcess $visitable): Extractor {
        return $visitable->getObjectExtractor();
    }

    public function getInjector(InjectorProcess $visitable): Injector {
        return $visitable->getObjectInjector();
    }

    public function key(): string {
        return $this->class;
    }
}