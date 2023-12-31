<?php

namespace OneMoreAngle\Marshaller\Api;

use Exception;
use OneMoreAngle\Marshaller\Extract\ExtractionManager;
use OneMoreAngle\Marshaller\Extract\ExtractionProcess;
use OneMoreAngle\Marshaller\Inject\InjectionManager;
use OneMoreAngle\Marshaller\Inject\InjectionProcess;
use OneMoreAngle\Marshaller\Meta\AttributeMetaExtractor;
use OneMoreAngle\Marshaller\Meta\DoctrineAnnotationMetaExtractor;
use OneMoreAngle\Marshaller\Meta\FallThroughMetaExtractor;
use OneMoreAngle\Marshaller\Meta\FallThroughPropertyMetaDataProvider;
use OneMoreAngle\Marshaller\Meta\MetaExtractor;
use OneMoreAngle\Marshaller\Meta\MetaExtractorBasedPropertyMetadataProvider;
use OneMoreAngle\Marshaller\Meta\PropertyMetadataProvider;
use OneMoreAngle\Marshaller\Meta\ReflectionPropertyMetadataProvider;
use OneMoreAngle\Marshaller\Serialization\SerializationVisitor;

class SerializerBuilder {
    private ?ExtractionProcess $extractionProcess = null;
    private ?InjectionProcess $injectionProcess = null;
    private ?SerializationVisitor $codec = null;
    private ?MetaExtractor $metaExtractor = null;
    private ?PropertyMetadataProvider $propertyMetadataProvider = null;

    public function withExtractionManager(ExtractionProcess $extractionProcess): SerializerBuilder {
        $this->extractionProcess = $extractionProcess;
        return $this;
    }

    public function withCodec(SerializationVisitor $codec): SerializerBuilder {
        $this->codec = $codec;
        return $this;
    }

    public function withMetaExtractor(MetaExtractor $metaExtractor): SerializerBuilder {
        $this->metaExtractor = $metaExtractor;
        return $this;
    }

    public function withInjectorManager(InjectionProcess $injectionProcess): SerializerBuilder {
        $this->injectionProcess = $injectionProcess;
        return $this;
    }

    public function withPropertyMetadataProvider(PropertyMetadataProvider $propertyMetadataProvider): SerializerBuilder {
        $this->propertyMetadataProvider = $propertyMetadataProvider;
        return $this;
    }

    /**
     * @throws Exception
     */
    public function build(): Serializer {
        $this->extractionProcess = $this->extractionProcess ?? new ExtractionManager($this->getMetaExtractor(), $this->getPropertyMetadataProvider());
        $this->injectionProcess = $this->injectionProcess ?? new InjectionManager($this->getMetaExtractor(), $this->getPropertyMetadataProvider());

        if($this->codec === null) {
            throw new Exception('A codec is required, none was provided in the builder');
        }

        return new Serializer($this->extractionProcess, $this->injectionProcess, $this->codec);
    }

    private function getMetaExtractor() : MetaExtractor {
        return $this->metaExtractor ?? $this->getDefaultMetaExtractor();
    }

    private function getDefaultMetaExtractor(): MetaExtractor {
        $fallThroughExtractor = new FallThroughMetaExtractor();

        // PHP 8.0.0 or higher takes precedence
        if (version_compare(PHP_VERSION, '8.0.0', '>=')) {
            $fallThroughExtractor->addExtractor(new AttributeMetaExtractor());
        }

        // If we are on PHP 7.4 or higher and doctrine annotations are available, we use it as a fallback
        if(class_exists('\Doctrine\Common\Annotations\AnnotationReader')) {
            $fallThroughExtractor->addExtractor(new DoctrineAnnotationMetaExtractor());
        }

        if(!count($fallThroughExtractor->getExtractors())) {
            throw new Exception('No metadata extractors available. If you are using a PHP version in between 7.4 and 8.0, please install doctrine/annotations');
        }

        return $fallThroughExtractor;
    }

    /**
     * @throws Exception
     */
    private function getPropertyMetadataProvider(): PropertyMetadataProvider {
        if($this->propertyMetadataProvider === null) {
            $metaExtractor = $this->getMetaExtractor();
            $metaReader = new MetaExtractorBasedPropertyMetadataProvider($metaExtractor);
            $reflectionReader = new ReflectionPropertyMetadataProvider();
            $this->propertyMetadataProvider = new FallThroughPropertyMetaDataProvider([$metaReader, $reflectionReader]);
        }
        return $this->propertyMetadataProvider;
    }
}