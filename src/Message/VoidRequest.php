<?php
namespace Omnipay\Bankart\Message;

use Omnipay\Bankart\e24PaymentPipe;
use Omnipay\Common\Exception\RuntimeException;

class VoidRequest extends AbstractRequest {

	/**
	 * Set transaction reference (Bankart Payment ID)
	 *
	 * @param string $value
	 * @return $this
	 */
	public function setTransactionReference($value)
	{
		return $this->setParameter('transactionReference', $value);
	}

	/**
	 * Get transaction reference (Bankart Payment ID)
	 *
	 * @return string
	 */
	public function getTransactionReference()
	{
		return $this->getParameter('transactionReference');
	}

	/**
	 * Set tranId
	 *
	 * @param string $value
	 * @return $this
	 */
	public function setTranId($value)
	{
		return $this->setParameter('tranId', $value);
	}

	/**
	 * Get tranId
	 *
	 * @return string
	 */
	public function getTranId()
	{
		return $this->getParameter('tranId');
	}

	/**
	 * Set trackId
	 *
	 * @param string $value
	 * @return $this
	 */
	public function setTrackId($value)
	{
		return $this->setParameter('trackId', $value);
	}

	/**
	 * Get trackId
	 *
	 * @return string
	 */
	public function getTrackId()
	{
		return $this->getParameter('trackId');
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
			'transactionReference',
			'tranId',
			'trackId'
		);

        return parent::getData() + [
			'amount' => $this->getAmount(),
			'transactionReference' => $this->getTransactionReference(),
			'tranId' => $this->getTranId(),
			'trackId' => $this->getTrackId(),
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
		$paymentPipe = new e24PaymentPipe;
		$paymentPipe->setResourcePath($this->getResourcePath());
		$paymentPipe->setAlias($this->getTerminalAlias());
		$paymentPipe->setAction(9);
		$paymentPipe->setAmt($this->getAmount());

		$paymentPipe->setPaymentId($this->getTransactionReference());
		$paymentPipe->setTranId($this->getTranId());
		$paymentPipe->setTrackId($this->getTrackId());

		$status = $paymentPipe->performPayment();

		$this->response = new VoidResponse($this, [
			'status' => ($status != $paymentPipe->SUCCESS) ? VoidResponse::STATUS_NOT_VOIDED : VoidResponse::STATUS_VOIDED,
		]);

		return $this->response;
	}
}
