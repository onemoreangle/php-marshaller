<?php

namespace OneMoreAngle\Marshaller\Pipeline;

/**
 * @template In
 * @template Out
 */
interface Stage {

    /**
     * @param Data<In> $input
     * @return Data<Out>
     */
    public function process(Data $input): Data;
}