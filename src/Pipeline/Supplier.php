<?php

namespace OneMoreAngle\Marshaller\Pipeline;

/**
 * @template R
 */
interface Supplier {

    /**
     * @return Data<R|null>
     */
    public function fetch(): Data;
}