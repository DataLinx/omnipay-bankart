<?php

namespace Omnipay\Bankart;

use Omnipay\Common\AbstractGateway;

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
class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Bankart';
    }

    public function getDefaultParameters()
    {
        return array(
			'resourcePath' => '',
			'terminalAlias' => '',
		);
    }

	/**
	 * Get resourcePath - location of the resource.cgn file
	 *
	 * @return string
	 */
	public function getResourcePath()
	{
		return $this->getParameter('resourcePath');
	}

	/**
	 * Set resource path
	 *
	 * @param string $value Path to the resource.cgn file
	 * @return $this
	 */
	public function setResourcePath($value)
	{
		return $this->setParameter('resourcePath', $value);
	}

	/**
	 * Get Terminal ID
	 *
	 * @return string
	 */
	public function getTerminalAlias()
    {
        return $this->getParameter('terminalAlias');
    }

	/**
	 * Set Terminal Alias
	 *
	 * @param string $value
	 * @return $this
	 */
	public function setTerminalAlias($value)
    {
        return $this->setParameter('terminalAlias', $value);
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
}
