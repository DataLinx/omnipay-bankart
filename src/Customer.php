<?php
namespace Omnipay\Bankart;

use Omnipay\Common\Exception\InvalidRequestException;

class Customer extends \PaymentGateway\Client\Data\Customer
{
    /**
     * Get associative array with all customer data
     *
     * @return array
     */
    public function getData()
    {
        $data = [];

        foreach (get_object_vars($this) as $key => $value) {
            if ($value !== NULL) {
                $data[$key] = $value;
            }
        }

        return $data;
    }

    /**
     * Validate the object before sending
     *
     * @throws InvalidRequestException
     */
    public function validate()
    {
        foreach (func_get_args() as $key) {
            if (! isset($this->$key)) {
                throw new InvalidRequestException("The $key parameter is required");
            }
        }
    }
}