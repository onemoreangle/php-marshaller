<?php

namespace OneMoreAngle\Marshaller\Extract;

interface ExtractorProcess extends Extractor {
    public function getPrimitiveExtractor() : Extractor;

    public function getObjectExtractor() : Extractor;

    public function getArrayExtractor() : Extractor;
}