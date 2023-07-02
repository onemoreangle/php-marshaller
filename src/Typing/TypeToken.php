<?php

namespace OneMoreAngle\Marshaller\Typing;

use OneMoreAngle\Marshaller\Data\IntermediaryData;
use OneMoreAngle\Marshaller\Extract\Extractor;
use OneMoreAngle\Marshaller\Extract\ExtractorProcess;
use OneMoreAngle\Marshaller\Inject\Injector;
use OneMoreAngle\Marshaller\Inject\InjectorProcess;

abstract class TypeToken {

    const NULL = "null";
    const ARRAY = "array";
    const BOOL = "boolean";
    const INT = "integer";
    const FLOAT = "float";
    const STRING = "string";
    const OBJECT = "object";

    protected static $types = [
        self::NULL,
        self::ARRAY,
        self::BOOL,
        self::INT,
        self::FLOAT,
        self::STRING,
        self::OBJECT
    ];

    protected string $type;

    protected function __construct($type) {
        $this->type = $type;
    }

    abstract public function getExtractor(ExtractorProcess $visitable): Extractor;

    abstract public function getInjector(InjectorProcess $visitable): Injector;

    abstract public function visit(TypeVisitor $visitable, IntermediaryData $data);

    /**
     * This gets a unique key for this type token. This is used to cache serializers
     * and deserializers as they are always the same for a given type token.
     * @return string
     */
    public abstract function key(): string;
}