<?php

namespace OneMoreAngle\Marshaller\Inject;

use OneMoreAngle\Marshaller\Inject\Handler\ArrayInjector;
use OneMoreAngle\Marshaller\Inject\Handler\ObjectInjector;
use OneMoreAngle\Marshaller\Inject\Handler\PrimitiveInjector;

interface TypeInjectorProvider extends Injector {

    public function getPrimitiveInjector() : Injector;

    public function getObjectInjector() : Injector;

    public function getArrayInjector() : Injector;
}