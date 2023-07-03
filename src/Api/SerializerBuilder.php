<?php

namespace OneMoreAngle\Marshaller\Api;

use Exception;
use OneMoreAngle\Marshaller\Extract\ExtractionManager;
use OneMoreAngle\Marshaller\Extract\ExtractorProcess;
use OneMoreAngle\Marshaller\Inject\InjectionManager;
use OneMoreAngle\Marshaller\Inject\InjectorProcess;
use OneMoreAngle\Marshaller\Meta\AttributeMetaExtractor;
use OneMoreAngle\Marshaller\Meta\DoctrineAnnotationMetaExtractor;
use OneMoreAngle\Marshaller\Meta\FallThroughPropertyMetaDataProvider;
use OneMoreAngle\Marshaller\Meta\MetaExtractor;
use OneMoreAngle\Marshaller\Meta\MetaExtractorBasedPropertyMetadataProvider;
use OneMoreAngle\Marshaller\Meta\PropertyMetadataProvider;
use OneMoreAngle\Marshaller\Meta\ReflectionPropertyMetadataProvider;
use OneMoreAngle\Marshaller\Serialization\SerializationVisitor;

class SerializerBuilder {
    private ?ExtractionManager $extractionManager = null;
    private ?InjectionManager $injectionManager = null;
    private ?SerializationVisitor $codec = null;
    private ?MetaExtractor $metaExtractor = null;
    private ?PropertyMetadataProvider $propertyMetadataProvider = null;

    public function withExtractionManager(ExtractorProcess $extractionManager): SerializerBuilder {
        $this->extractionManager = $extractionManager;
        return $this;
    }

    public function withCodec(SerializationVisitor $codec): SerializerBuilder {
        $this->codec = $codec;
        return $this;
    }

    public function withPropertyMetadataProvider(MetaExtractor $metaExtractor): SerializerBuilder {
        $this->metaExtractor = $metaExtractor;
        return $this;
    }

    public function withInjectorManager(InjectorProcess $injectionManager): SerializerBuilder {
        $this->injectionManager = $injectionManager;
        return $this;
    }

    /**
     * @throws Exception
     */
    public function build(): Serializer {
        $this->extractionManager = $this->extractionManager ?? new ExtractionManager();
        $this->injectionManager = $this->injectionManager ?? new InjectionManager($this->getPropertyMetadataProvider());

        if($this->codec === null) {
            throw new Exception('A codec is required, none was provided in the builder');
        }

        return new Serializer($this->extractionManager, $this->injectionManager, $this->codec);
    }

    private function getDefaultMetaExtractor(): MetaExtractor {
        if (version_compare(PHP_VERSION, '8.0.0', '>=')) {
            return new AttributeMetaExtractor();
        } else if(class_exists('\Doctrine\Common\Annotations\AnnotationReader')) {
            return new DoctrineAnnotationMetaExtractor();
        } else {
            throw new Exception('No metadata extractor available. If you are using a PHP version in between 7.4 and 8.0, please install doctrine/annotations');
        }
    }

    /**
     * @throws Exception
     */
    private function getPropertyMetadataProvider(): PropertyMetadataProvider {
        if($this->propertyMetadataProvider === null) {
            $metaExtractor = $this->metaExtractor ?? $this->getDefaultMetaExtractor();
            $metaReader = new MetaExtractorBasedPropertyMetadataProvider($metaExtractor);
            $reflectionReader = new ReflectionPropertyMetadataProvider();
            $this->propertyMetadataProvider = new FallThroughPropertyMetaDataProvider([$metaReader, $reflectionReader]);
        }
        return $this->propertyMetadataProvider;
    }
}