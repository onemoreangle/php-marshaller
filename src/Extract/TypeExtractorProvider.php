<?php

namespace OneMoreAngle\Marshaller\Extract;

interface TypeExtractorProvider {
    public function getPrimitiveExtractor() : Extractor;

    public function getObjectExtractor() : Extractor;

    public function getArrayExtractor() : Extractor;
}