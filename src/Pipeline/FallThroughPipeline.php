<?php

namespace OneMoreAngle\Marshaller\Pipeline;

/**
 * @template R
 * @implements Supplier<R>
 */
class FallThroughPipeline implements Supplier {

    /**
     * @var Supplier<R>[]
     */
    private array $steps;

    /**
     * @param array<Supplier<R>> $steps
     */
    public function __construct(array $steps) {
        $this->steps = $steps;
    }

    /**
     * @return Data<R|null>
     */
    public function fetch(): Data {
        /** @var Data<R|null> $current */
        $current = null;
        foreach($this->steps as $step) {
            $temp = $step->fetch();
            if ($temp->getValue() !== null) {
                return $temp;
            }
        }
        return $current;
    }
}
