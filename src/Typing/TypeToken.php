<?php

namespace OneMoreAngle\Marshaller\Typing;

use OneMoreAngle\Marshaller\Data\IntermediaryData;
use OneMoreAngle\Marshaller\Extract\Extractor;
use OneMoreAngle\Marshaller\Extract\TypeExtractorProvider;
use OneMoreAngle\Marshaller\Inject\Injector;
use OneMoreAngle\Marshaller\Inject\TypeInjectorProvider;

abstract class TypeToken {

    const NULL = "null";
    const ARRAY = "array";
    const BOOL = "boolean";
    const INT = "integer";
    const FLOAT = "float";
    const STRING = "string";
    const OBJECT = "object";

    /**
     * @var string[]
     */
    protected static $types = [
        self::NULL,
        self::ARRAY,
        self::BOOL,
        self::INT,
        self::FLOAT,
        self::STRING,
        self::OBJECT
    ];

    /**
     * @param string $type
     */
    protected string $type;

    /**
     * @param string $type
     */
    protected function __construct($type) {
        $this->type = $type;
    }

    /**
     * @param TypeExtractorProvider $visitable
     * @return Extractor<mixed> the extractor for this token's type
     */
    abstract public function getExtractor(TypeExtractorProvider $visitable): Extractor;

    /**
     * @param TypeInjectorProvider $visitable
     * @return Injector<mixed> the injector for this token's type
     */
    abstract public function getInjector(TypeInjectorProvider $visitable): Injector;

    abstract public function visit(TypeVisitor $visitable, IntermediaryData $data) : void;

    /**
     * This gets a unique key for this type token. This is used to cache serializers
     * and deserializers as they are always the same for a given type token.
     * @return string
     */
    public abstract function key(): string;
}