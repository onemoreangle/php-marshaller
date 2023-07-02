<?php

namespace OneMoreAngle\Marshaller\Extract;

interface ExtractorProcess {
    public function getPrimitiveExtractor() : Extractor;

    public function getObjectExtractor() : Extractor;

    public function getArrayExtractor() : Extractor;
}