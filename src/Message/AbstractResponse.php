<?php
namespace Omnipay\Bankart\Message;

use Omnipay\Common\Message\AbstractResponse as OmnipayAbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use PaymentGateway\Client\Transaction\Error;
use PaymentGateway\Client\Transaction\Result as BankartResult;

abstract class AbstractResponse extends OmnipayAbstractResponse
{
    /**
     * @var BankartResult
     */
    protected $bankartResult;

    public function __construct(RequestInterface $request, $data, BankartResult $bankartResult)
    {
        parent::__construct($request, $data);

        $this->bankartResult = $bankartResult;
    }

    /**
     * Get response data
     *
     * @return array
     */
    public function getData()
    {
        return parent::getData() + [
            'bankartResult' => $this->bankartResult
        ];
    }

    /**
     * Get response code
     *
     * @return int|string|null
     */
    public function getCode()
    {
        $error = $this->bankartResult->getFirstError();

        return $error ? $error->getCode() : NULL;
    }

    /**
     * Get response error message (if they occurred)
     *
     * @return string|null
     */
    public function getMessage()
    {
        return $this->bankartResult->hasErrors() ? $this->serializeErrors($this->bankartResult->getErrors()) : NULL;
    }

    /**
     * Serialize errors array to a string
     *
     * @param Error[] $errors
     * @return string
     */
    protected function serializeErrors(array $errors)
    {
        $str = '';

        foreach ($errors as $error)
        {
            $str .= $error->getMessage() .' (code: '. $error->getCode() .')';
        }

        return $str;
    }
}
