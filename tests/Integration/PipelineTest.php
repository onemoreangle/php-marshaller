<?php
namespace OneMoreAngle\Marshaller\Test\Integration;

use OneMoreAngle\Marshaller\Pipeline\Data;
use OneMoreAngle\Marshaller\Pipeline\PipelineBuilder;
use OneMoreAngle\Marshaller\Pipeline\Stage;

use PHPUnit\Framework\TestCase;

class PipelineTest extends TestCase {
    public function testPipeline() {
        $addStage = new class(2) implements Stage {
            private int $amount;

            public function __construct($amount) {
                $this->amount = $amount;
            }

            public function process(Data $input): Data {
                return new Data($input->getValue() + $this->amount);
            }

            public function getAmount(): int {
                return $this->amount;
            }
        };

        $squareStage = new class implements Stage {
            public function process(Data $input): Data {
                return new Data(pow($input->getValue(), 2));
            }
        };

        $pipeline = PipelineBuilder::create($addStage)->add($squareStage)->build();

        $in = new Data(6);
        $out = $pipeline->process($in);
        $expected = pow($in->getValue() + $addStage->getAmount(), 2);
        $this->assertTrue($out->getValue() === $expected, "Pipeline output is invalid, should be $expected");
    }
}