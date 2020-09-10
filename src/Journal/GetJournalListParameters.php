<?php

namespace BaselinkerClient\Journal;

use BaselinkerClient\Lib\Base\BaseParameters;
use BaselinkerClient\Lib\Annotations\Field;
use BaselinkerClient\Lib\Annotations\Validator;

class GetJournalListParameters extends BaseParameters
{
    /**
     * @var int
     * @Field("last_login_id")
     * @Validator("NotNull")
     */
    public $lastLogId;

    /**
     * @var array
     * @Field("logs_types", type="array")
     * @Validator("NotBlank")
     */
    public $logsTypes;

    /**
     * @var int|null
     * @Field("order_id")
     */
    public $orderId;

    const CREATE_ORDER = 1;
    const FOD_DOWNLOAD = 2;
    const PAYMENT_ORDER = 3;
    const REMOVE_ORDER = 4;
    const COMBINE_ORDERS = 5;
    const SEPARATE_ORDER = 6;
    const ISSUE_INVOICE = 7;
    const ISSUE_RECEIPT = 8;
    const CREATE_SHIPMENT = 9;
    const REMOVE_SHIPMENT = 10;
    const EDIT_DELIVERY_DATA = 11;
    const ADD_PRODUCT_TO_ORDER = 12;
    const EDIT_PRODUCT_IN_ORDER = 13;
    const REMOVE_PRODUCT_FROM_ORDER = 14;
    const ADD_BUYER_TO_BLACK_LIST = 15;
    const EDIT_ORDER_DATA = 16;
    const COPY_ORDER = 17;
    const ORDER_STATUS_CHANGE = 18;
    const REMOVING_INVOICE = 19;
    const REMOVING_RECEIPT = 20;

    public function __construct(int $lastLogId = null, array $logsTypes = [], int $orderId = null)
    {
        $this->lastLogId = $lastLogId;
        $this->logsTypes = $logsTypes;
        $this->orderId = $orderId;

        return $this;
    }
}
