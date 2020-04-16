<?php
namespace Omnipay\Bankart\Message;

use PaymentGateway\Client\Client as BankartClient;
use PaymentGateway\Client\Transaction\Refund as BankartRefund;

class RefundRequest extends AbstractRequest
{
    /**
     * @inheritDoc
     */
    public function getData()
    {
        $this->validate(
            'transactionId',
            'amount',
            'currency',
            'transactionReference'
        );

        return parent::getData() + [
            'transactionId' => $this->getTransactionId(),
            'amount' => $this->getAmount(),
            'currency' => $this->getCurrency(),
            'transactionReference' => $this->getTransactionReference(),
        ];
    }

    /**
     * @inheritDoc
     */
    public function sendData($data)
    {
        $client = new BankartClient($this->getUsername(), $this->getPassword(), $this->getApiKey(), $this->getSharedSecret());

        $refund = new BankartRefund();
        $refund->setTransactionId($this->getTransactionId())
            ->setAmount($this->getAmount())
            ->setCurrency($this->getCurrency())
            ->setReferenceTransactionId($this->getTransactionReference());

        $this->response = new RefundResponse($this, [], $client->refund($refund));

        return $this->response;
    }
}
