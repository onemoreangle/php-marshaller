<?php

namespace OneMoreAngle\Marshaller\Serialization;

use OneMoreAngle\Marshaller\Data\IntermediaryData;
interface SerializationVisitor {

    /**
     * @param IntermediaryData $data
     * @return string|false
     */
    public function serialize(IntermediaryData $data);

    /**
     * @param string $input
     * @return IntermediaryData
     */
    public function deserialize(string $input) : IntermediaryData;
}