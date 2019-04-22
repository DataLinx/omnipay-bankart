<?php
namespace Omnipay\Bankart\Message;

use Omnipay\Bankart\e24PaymentPipe;
use Omnipay\Common\Exception\RuntimeException;

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
	 * Return URL for failed transactions
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
			'notifyUrl',
			'errorUrl'
		);

        return parent::getData() + [
			'amount' => $this->getAmount(),
			'currency' => $this->getCurrency(),
			'language' => $this->getLanguage(),
			'notifyUrl' => $this->getNotifyUrl(),
			'errorUrl' => $this->getErrorUrl(),
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
		$paymentPipe = new e24PaymentPipe;
		$paymentPipe->setResourcePath($this->getResourcePath());
		$paymentPipe->setAlias($this->getTerminalAlias());
		$paymentPipe->setAction(4);
		$paymentPipe->setAmt($this->getAmount());
		$paymentPipe->setCurrency($this->getCurrency());
		$paymentPipe->setLanguage($this->getLanguage());
		$paymentPipe->setResponseURL($this->getNotifyUrl());
		$paymentPipe->setErrorURL($this->getErrorUrl());
		$paymentPipe->setTrackId(md5(uniqid()));

		if ($paymentPipe->performPaymentInitialization() != $paymentPipe->SUCCESS)
		{
			throw new RuntimeException('Payment Pipe initializaton error - '. $paymentPipe->getErrorMsg());
		}

		$this->response = new AuthorizeResponse($this, [
			'transactionReference' => $paymentPipe->getPaymentId(),
			'redirectUrl' => $paymentPipe->getPaymentPage() . '?PaymentID='. $paymentPipe->getPaymentId(),
		]);

		return $this->response;
	}
}
