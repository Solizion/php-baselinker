<?php

namespace BaselinkerClient\Lib\Base;

use BaselinkerClient\Lib\Annotations\Field;
use BaselinkerClient\Lib\Annotations\Validator;
use BaselinkerClient\Lib\Exceptions\InvalidParameterException;
use Doctrine\Common\Annotations\AnnotationReader;
use Exception;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\Validator\Validation;

class BaseParameters
{
    /**
     * @throws InvalidParameterException
     * @throws Exception
     */
    public function validate()
    {
        $validator = Validation::createValidator();

        $mappedProperties = $this->mapAnnotationsFromProperties(Validator::class);

        foreach ($mappedProperties as $key => $value) {
            $assert = 'Symfony\\Component\\Validator\\Constraints\\' . $value;

            if (!class_exists($assert)) {
                throw new Exception('Invalid validation key ' . $value);
            }

            $violation = $validator->validate($this->{$key}, [
                new $assert,
            ]);

            if (0 !== count($violation)) {
                throw new InvalidParameterException($violation[0]->getMessage());
            }
        }
    }

    protected function mapAnnotationsFromProperties($annotationClass): array
    {
        try {
            $reflectionClass = new ReflectionClass('\\' . get_class($this));
            $properties = $reflectionClass->getProperties();
        } catch (ReflectionException $e) {
            $properties = [];
        }

        $annotationReader = new AnnotationReader();

        $mapperAnnotations = [];

        foreach ($properties as $property) {
            $annotation = $annotationReader->getPropertyAnnotation($property, $annotationClass);
            if (null !== $annotation) {
                $mapperAnnotations[$property->name] = $annotation->fieldName;
            }
        }

        return $mapperAnnotations;
    }

    public function toRequest(): array
    {
        $requestData = [];

        $mappedProperties = $this->mapAnnotationsFromProperties(Field::class);

        foreach ($mappedProperties as $key => $value) {
            $requestData[$value] = $this->{$key};
        }

        return $requestData;
    }
}
