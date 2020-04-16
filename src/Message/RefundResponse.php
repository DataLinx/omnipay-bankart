<?php
namespace Omnipay\Bankart\Message;

use PaymentGateway\Client\Transaction\Result as BankartResult;

class RefundResponse extends AbstractResponse
{
    /**
     * @inheritDoc
     */
    public function isSuccessful()
    {
        return $this->bankartResult->getReturnType() === BankartResult::RETURN_TYPE_FINISHED;
    }
}