<?php

namespace OneMoreAngle\Marshaller\Pipeline;

/**
 * @template In
 * @template Out
 */
class PipelineBuilder {
    /**
     * @var Stage[]
     */
    private array $stages = [];

    /**
     * @param Stage<In, Out> $stage
     * @return PipelineBuilder<In, Out>
     */
    public static function create(Stage $stage): PipelineBuilder {
        return new PipelineBuilder($stage);
    }

    /**
     * @param Stage<In, Out> $stage
     */
    private function __construct(Stage $stage) {
        $this->stages[] = $stage;
    }

    /**
     * Adds a stage to the pipeline and changes the generic
     * type of the pipeline to the output type of the stage.
     * @template NextOut
     * @param Stage<Out, NextOut> $stage
     * @return PipelineBuilder<In, NextOut>
     */
    public function add(Stage $stage): PipelineBuilder {
        $this->stages[] = $stage;
        return $this;
    }

    /**
     * @return Pipeline<In, Out>
     */
    public function build(): Pipeline {
        return new Pipeline($this->stages);
    }
}