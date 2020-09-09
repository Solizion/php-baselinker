<?php

namespace BaselinkerClient\Lib\Base;

class BaseResponse
{
    /** @var array */
    protected $responseData;

    public function __construct(array $responseData)
    {
        $this->responseData = $responseData;

        return $this;
    }

    public function getData(): array
    {
        return $this->responseData;
    }

    public function checkError(): bool
    {
        return $this->responseData['status'] === 'ERROR';
    }

    public function getErrorMessage(): array
    {
        return [
            'status' => 'ERROR',
            'error_code' => $this->responseData['error_code'],
            'error_message' => $this->responseData['error_message']
        ];
    }
}
