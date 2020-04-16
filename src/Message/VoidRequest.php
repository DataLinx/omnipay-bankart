<?php
namespace Omnipay\Bankart\Message;

use Omnipay\Common\Exception\RuntimeException;
use PaymentGateway\Client\Client as BankartClient;
use PaymentGateway\Client\Transaction\VoidTransaction;

class VoidRequest extends AbstractRequest
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
			'transactionReference'
		);

        return parent::getData() + [
            'transactionId' => $this->getTransactionId(),
			'transactionReference' => $this->getTransactionReference(),
		];
    }

	/**
	 * Send request
	 *
	 * @param array $data Dummy data array just to match the interface
	 * @return VoidResponse
	 * @throws RuntimeException
	 */
	public function sendData($data)
	{
        $client = new BankartClient($this->getUsername(), $this->getPassword(), $this->getApiKey(), $this->getSharedSecret());

        $void = new VoidTransaction();
        $void->setTransactionId($this->getTransactionId())
             ->setReferenceTransactionId($this->getTransactionReference());

        $this->response = new VoidResponse($this, [], $client->void($void));

        return $this->response;
	}
}
