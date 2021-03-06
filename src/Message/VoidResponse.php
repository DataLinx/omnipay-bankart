<?php
namespace Omnipay\Bankart\Message;

use PaymentGateway\Client\Transaction\Result as BankartResult;

class VoidResponse extends AbstractResponse
{
	/**
	 * Was the void successful?
	 *
	 * @return boolean
	 */
	public function isSuccessful()
	{
        return $this->bankartResult->getReturnType() === BankartResult::RETURN_TYPE_FINISHED;
	}
}
