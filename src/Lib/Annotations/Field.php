<?php

namespace BaselinkerClient\Lib\Annotations;

/** @Annotation */
class Field
{
    /** @var string */
    public $fieldName;

    /** @var string|null */
    public $type;

    /** @var array|null */
    public $fields;

    public function __construct(array $data)
    {
        $this->fieldName = $data['value'];
        if (array_key_exists('type', $data)) {
            $this->type = $data['type'];
            $this->fields = array_key_exists('fields', $data) ? $data['fields'] : [];
        }
    }
}
