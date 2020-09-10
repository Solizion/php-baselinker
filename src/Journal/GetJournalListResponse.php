<?php

namespace BaselinkerClient\Journal;

use BaselinkerClient\Lib\Base\BaseResponse;

class GetJournalListResponse extends BaseResponse
{
    public function getLogs(): array
    {
        return (isset($this->responseData['logs'])) ? $this->responseData['logs'] : [];
    }
}
