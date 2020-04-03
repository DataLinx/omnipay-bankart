<?php
namespace Omnipay\Bankart\Message;

use PaymentGateway\Client\Transaction\Error;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    /**
     * Set username
     *
     * @param string $username
     * @return $this
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
     * @return $this
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
     * @return $this
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
     * @return $this
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
	 * Get common request data
	 *
	 * @return array
	 */
	public function getData()
	{
		$this->validate(
			'username',
			'password',
            'apiKey',
            'sharedSecret'
		);

		return array(
			'username' => $this->getUsername(),
            'password' => $this->getPassword(),
            'apiKey' => $this->getApiKey(),
            'sharedSecret' => $this->getSharedSecret(),
		);
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
