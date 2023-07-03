<?php

namespace OneMoreAngle\Marshaller\Implementation;

use OneMoreAngle\Marshaller\Meta\PropertyMetadataProvider;

interface Process {

    public function getPropertyMetadataProvider() : PropertyMetadataProvider;
}