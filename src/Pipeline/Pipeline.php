<?php

namespace OneMoreAngle\Marshaller\Pipeline;

/**
 * @template In
 * @template Out
 * @implements Stage<In, Out>
 */
class Pipeline implements Stage {

    /**
     * @var Stage[]
     */
    private array $stages;

    /**
     * @param array<Stage<mixed, mixed>> $stages
     */
    public function __construct(array $stages) {
        $this->stages = $stages;
    }

    /**
     * @param Data<In> $input
     * @return Data<Out>
     */
    public function process(Data $input): Data {
        /** @var Data<mixed> $current, we are only aware that $stages[0] has Data<In> as input, and that the last stages outputs Data<Out> */
        $current = $input;
        foreach($this->stages as $stage) {
            $current = $this->next($stage, $current);
        }

        /** @var Data<Out> $current last one is always Out by construction */
        return $current;
    }

    /**
     * @template I
     * @template O
     * @param Stage<I, O> $stage
     * @param Data<I> $input
     * @return Data<O>
     */
    private function next(Stage $stage, Data $input): Data {
        return $stage->process($input);
    }
}