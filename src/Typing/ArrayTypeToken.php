<?php

namespace OneMoreAngle\Marshaller\Typing;

use OneMoreAngle\Marshaller\Data\IntermediaryData;
use OneMoreAngle\Marshaller\Extract\Extractor;
use OneMoreAngle\Marshaller\Extract\TypeExtractorProvider;
use OneMoreAngle\Marshaller\Inject\Injector;
use OneMoreAngle\Marshaller\Inject\TypeInjectorProvider;

class ArrayTypeToken extends TypeToken {

    /**
     * @var ArrayTypeToken[]
     */
    protected static array $instanceCache = [];

    protected ?TypeToken $arrayType = null;

    protected function __construct() {
        parent::__construct(static::ARRAY);
    }

    public static function create(?TypeToken $type = null): ArrayTypeToken {
        $cid = $type !== null ? $type->key() : static::ARRAY;

        if(!isset(static::$instanceCache[$cid])) {
            $token = new ArrayTypeToken();
            $token->setArrayType($type);
            static::$instanceCache[$cid] = $token;
        }

        return static::$instanceCache[$cid];
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

    /**
     * @return TypeToken|null
     */
    public function getArrayType(): ?TypeToken {
        return $this->arrayType;
    }

    /**
     * @param TypeToken|null $arrayType
     */
    public function setArrayType(?TypeToken $arrayType): void {
        $this->arrayType = $arrayType;
    }

    public function isTyped(): bool {
        return $this->arrayType !== null;
    }

    public function key(): string {
        return static::ARRAY;
    }
}