<?php

namespace OneMoreAngle\Marshaller\Pipeline;


/**
 * @template R
 */
class FallThroughPipelineBuilder {

    /**
     * @var Supplier<R>[]
     */
    private array $steps = [];

    /**
     * @param Supplier<R> $step
     * @return FallThroughPipelineBuilder<R>
     */
    public static function create(Supplier $step): FallThroughPipelineBuilder {
        return new FallThroughPipelineBuilder($step);
    }

    /**
     * @param Supplier<R> $step
     */
    private function __construct(Supplier $step) {
        $this->steps[] = $step;
    }

    /**
     * Adds a step to the pipeline.
     * @param Supplier<R> $step
     * @return FallThroughPipelineBuilder<R>
     */
    public function add(Supplier $step): FallThroughPipelineBuilder {
        $this->steps[] = $step;
        return $this;
    }

    /**
     * @return FallThroughPipeline<R>
     */
    public function build(): FallThroughPipeline {
        return new FallThroughPipeline($this->steps);
    }
}