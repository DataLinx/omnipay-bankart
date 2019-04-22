<?php
namespace Omnipay\Bankart\Message;

use Omnipay\Common\Message\AbstractResponse;

class CaptureResponse extends AbstractResponse {

	/**
	 * Transaction captured
	 */
	const STATUS_CAPTURED = 'CAPTURED';

	/**
	 * Transaction not captured
	 */
	const STATUS_NOT_CAPTURED = 'NOT CAPTURED';

	/**
	 * Get capture status. See class constants for available values.
	 *
	 * @return string
	 */
	public function getStatus()
	{
		return $this->data['status'];
	}

	/**
	 * Was the capture successful?
	 *
	 * @return boolean
	 */
	public function isSuccessful()
	{
		return $this->getStatus() === self::STATUS_CAPTURED;
	}
}
