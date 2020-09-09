<?php

namespace BaselinkerClient\Lib\Annotations;

/** @Annotation */
class Validator
{
    /** @var string */
    public $fieldName;

    public function __construct(array $data)
    {
        $this->fieldName = $data['value'];
    }
}
