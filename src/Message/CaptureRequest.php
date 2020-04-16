<?php
namespace Omnipay\Bankart\Message;

use Omnipay\Common\Exception\RuntimeException;
use PaymentGateway\Client\Client as BankartClient;
use PaymentGateway\Client\Transaction\Capture as BankartCapture;

class CaptureRequest extends AbstractRequest
{
	/**
	 * Get request data
	 *
	 * @return array
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
	 * Send request
	 *
	 * @param array $data Dummy data array just to match the interface
	 * @return CaptureResponse
	 * @throws RuntimeException
	 */
	public function sendData($data)
	{
	    $client = new BankartClient($this->getUsername(), $this->getPassword(), $this->getApiKey(), $this->getSharedSecret());

        $capture = new BankartCapture();
        $capture->setTransactionId($this->getTransactionId())
            ->setAmount($this->getAmount())
            ->setCurrency($this->getCurrency())
            ->setReferenceTransactionId($this->getTransactionReference());

        $this->response = new CaptureResponse($this, [], $client->capture($capture));

        return $this->response;
	}
}
