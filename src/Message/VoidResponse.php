<?php
namespace Omnipay\Bankart\Message;

use Omnipay\Common\Message\AbstractResponse;

class VoidResponse extends AbstractResponse {

	/**
	 * Transaction voided
	 */
	const STATUS_VOIDED = 'VOIDED';

	/**
	 * Transaction not voided
	 */
	const STATUS_NOT_VOIDED = 'NOT VOIDED';

	/**
	 * Get void status. See class constants for available values.
	 *
	 * @return string
	 */
	public function getStatus()
	{
		return $this->data['status'];
	}

	/**
	 * Was the void successful?
	 *
	 * @return boolean
	 */
	public function isSuccessful()
	{
		return $this->getStatus() === self::STATUS_VOIDED;
	}
}
