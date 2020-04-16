<?php

namespace Omnipay\Bankart;

use Omnipay\Common\AbstractGateway as AbstractGatewayAlias;

/**
 * Dummy Gateway
 *
 * This gateway is useful for testing. It simply authorizes any payment made using a valid
 * credit card number and expiry.
 *
 * Any card number which passes the Luhn algorithm and ends in an even number is authorized,
 * for example: 4242424242424242
 *
 * Any card number which passes the Luhn algorithm and ends in an odd number is declined,
 * for example: 4111111111111111
 *
 * ### Example
 *
 * <code>
 * // Create a gateway for the Dummy Gateway
 * // (routes to GatewayFactory::create)
 * $gateway = Omnipay::create('Dummy');
 *
 * // Initialise the gateway
 * $gateway->initialize(array(
 *     'testMode' => true, // Doesn't really matter what you use here.
 * ));
 *
 * // Create a credit card object
 * // This card can be used for testing.
 * $card = new CreditCard(array(
 *             'firstName'    => 'Example',
 *             'lastName'     => 'Customer',
 *             'number'       => '4242424242424242',
 *             'expiryMonth'  => '01',
 *             'expiryYear'   => '2020',
 *             'cvv'          => '123',
 * ));
 *
 * // Do a purchase transaction on the gateway
 * $transaction = $gateway->purchase(array(
 *     'amount'                   => '10.00',
 *     'currency'                 => 'AUD',
 *     'card'                     => $card,
 * ));
 * $response = $transaction->send();
 * if ($response->isSuccessful()) {
 *     echo "Purchase transaction was successful!\n";
 *     $sale_id = $response->getTransactionReference();
 *     echo "Transaction reference = " . $sale_id . "\n";
 * }
 * </code>
 */
class Gateway extends AbstractGatewayAlias
{
    public function getName()
    {
        return 'Bankart';
    }

    public function getDefaultParameters()
    {
        return array(
            'username' => '',
            'password' => '',
            'apiKey' => '',
            'sharedSecret' => '',
		);
    }

    /**
     * Set username
     *
     * @param string $username
     * @return Gateway
     */
    public function setUsername($username)
    {
        return $this->setParameter('username', $username);
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->getParameter('username');
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Gateway
     */
    public function setPassword($password)
    {
        return $this->setParameter('password', $password);
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->getParameter('password');
    }

    /**
     * Set API key
     *
     * @param string $apiKey
     * @return Gateway
     */
    public function setApiKey($apiKey)
    {
        return $this->setParameter('apiKey', $apiKey);
    }

    /**
     * Get API key
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }

    /**
     * Set shared secret
     *
     * @param string $sharedSecret
     * @return Gateway
     */
    public function setSharedSecret($sharedSecret)
    {
        return $this->setParameter('sharedSecret', $sharedSecret);
    }

    /**
     * Get shared secret
     *
     * @return string
     */
    public function getSharedSecret()
    {
        return $this->getParameter('sharedSecret');
    }

    /**
     * Create an authorize request.
     *
     * @param array $parameters
     * @return \Omnipay\Bankart\Message\AuthorizeRequest
     */
    public function authorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Bankart\Message\AuthorizeRequest', $parameters);
    }

	/**
	 * Create a capture request.
	 *
	 * @param array $parameters Parameters
	 * @return \Omnipay\Bankart\Message\CaptureRequest
	 */
	public function capture(array $parameters = array())
	{
		return $this->createRequest('\Omnipay\Bankart\Message\CaptureRequest', $parameters);
	}

	/**
	 * Create a void request.
	 *
	 * @param array $parameters Parameters
	 * @return \Omnipay\Bankart\Message\VoidRequest
	 */
	public function void(array $parameters = array())
	{
		return $this->createRequest('\Omnipay\Bankart\Message\VoidRequest', $parameters);
	}

    /**
     * Create a refund request.
     *
     * @param array $parameters Parameters
     * @return \Omnipay\Bankart\Message\RefundRequest
     */
	public function refund(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Bankart\Message\RefundRequest', $parameters);
    }
}
