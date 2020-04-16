<?php
namespace Omnipay\Bankart\Message;

use PaymentGateway\Client\Transaction\Result as BankartResult;

class CaptureResponse extends AbstractResponse
{
    /**
	 * Was the capture successful?
	 *
	 * @return boolean
	 */
	public function isSuccessful()
	{
	    return $this->bankartResult->getReturnType() === BankartResult::RETURN_TYPE_FINISHED;
	}
}
