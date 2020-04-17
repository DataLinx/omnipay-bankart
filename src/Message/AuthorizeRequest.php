<?php
namespace Omnipay\Bankart\Message;

use Omnipay\Bankart\Customer;
use Omnipay\Common\Exception\RuntimeException;
use PaymentGateway\Client\Client as BankartClient;
use PaymentGateway\Client\Transaction\Preauthorize as BankartPreauthorize;
use PaymentGateway\Client\Transaction\Result as BankartResult;

class AuthorizeRequest extends AbstractRequest
{
	/**
	 * Set payment page language. See Readme.md for available options.
	 * 
	 * @param string $value
	 * @return $this
	 */
	public function setLanguage($value)
	{
		return $this->setParameter('language', $value);
	}

	/**
	 * Get payment page language
	 *
	 * @return string
	 */
	public function getLanguage()
	{
		return $this->getParameter('language');
	}

	/**
	 * Set URL for failed transactions
	 *
	 * @param string $value
	 * @return $this
	 */
	public function setErrorUrl($value)
	{
		return $this->setParameter('errorUrl', $value);
	}

	/**
	 * Get Error URL
	 *
	 * @return string
	 */
	public function getErrorUrl()
	{
		return $this->getParameter('errorUrl');
	}

    /**
     * Set customer
     *
     * @param Customer $customer
     * @return $this
     */
	public function setCustomer(Customer $customer)
    {
        return $this->setParameter('customer', $customer);
    }

    /**
     * Get customer
     *
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->getParameter('customer');
    }

	/**
	 * Get request data
	 *
	 * @return array
	 */
    public function getData()
    {
		$this->validate(
			'amount',
			'currency',
			'language',
			'returnUrl',
			'notifyUrl',
			'errorUrl',
            'cancelUrl',
            'transactionId',
            'description',
            'customer'
		);

		// Validate required Customer data
		$this->getCustomer()->validate(
		    'firstName',
            'lastName',
            'billingCountry',
            'email',
            'ipAddress'
        );

        return parent::getData() + [
			'amount' => $this->getAmount(),
			'currency' => $this->getCurrency(),
			'language' => $this->getLanguage(),
            'returnUrl' => $this->getReturnUrl(),
			'notifyUrl' => $this->getNotifyUrl(),
			'errorUrl' => $this->getErrorUrl(),
            'cancelUrl' => $this->getCancelUrl(),
            'transactionId' => $this->getTransactionId(),
            'description' => $this->getDescription(),
            'customer' => $this->getCustomer()->getData(),
		];
    }

	/**
	 * Send request
	 *
	 * @param array $data Dummy data array just to match the interface
	 * @return AuthorizeResponse
	 * @throws RuntimeException
	 */
	public function sendData($data)
	{
        $client = new BankartClient($this->getUsername(), $this->getPassword(), $this->getApiKey(), $this->getSharedSecret(), $this->getLanguage());

        $preauth = new BankartPreauthorize();
        $preauth->setTransactionId($this->getTransactionId())
            ->setAmount($this->getAmount())
            ->setCurrency($this->getCurrency())
            ->setDescription($this->getDescription())
            ->setSuccessUrl($this->getReturnUrl())
            ->setCancelUrl($this->getCancelUrl())
            ->setErrorUrl($this->getErrorUrl())
            ->setCallbackUrl($this->getNotifyUrl())
            ->setCustomer($this->getCustomer());

        $result = $client->preauthorize($preauth);

        switch ($result->getReturnType())
        {
            case BankartResult::RETURN_TYPE_REDIRECT:
                $this->response = new AuthorizeResponse($this, [], $result);
                return $this->response;

            case BankartResult::RETURN_TYPE_ERROR:
                throw new RuntimeException('Payment initialization error: '. $this->serializeErrors($result->getErrors()));

            default:
                throw new RuntimeException('Payment initialization error - unexpected return type: '. $result->getReturnType());
        }
	}
}
