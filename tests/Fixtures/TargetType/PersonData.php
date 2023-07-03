<?php

namespace OneMoreAngle\Marshaller\Test\Fixtures\TargetType;

use OneMoreAngle\Marshaller\Attribute\TargetType;

class PersonData {
    /**
     * @TargetType(CustomData::class)
     */
    #[TargetType(CustomData::class)]
    public $customData;
}