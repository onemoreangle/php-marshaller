<?php

namespace OneMoreAngle\Marshaller\Typing;

class ClassTypeToken extends TypeToken {

    private string $class;

    protected function __construct(string $class) {
        parent::__construct(TypeToken::OBJECT);
        $this->class = $class;
    }

    public function getClass(): string {
        return $this->class;
    }
}