<?php
namespace Omnipay\Bankart\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

/**
 * Bankart Authorize Response
 */
class AuthorizeResponse extends AbstractResponse implements RedirectResponseInterface {

	/**
	 * Always return FALSE, because we redirect the customer.
	 *
	 * @return boolean
	 */
	public function isSuccessful()
	{
		return FALSE;
	}

	/**
	 * Did we successfully receive the Redirect URL?
	 *
	 * @return boolean
	 */
	public function isRedirect()
	{
		return ! empty($this->getRedirectUrl());
	}

	/**
     * Always returns NULL.
     *
     * @return NULL
     */
	public function getRedirectData()
	{
		return NULL;
	}

	/**
     * Get the required redirect method (always GET).
     *
     * @return string
     */
	public function getRedirectMethod()
	{
		return 'GET';
	}

	/**
     * Get the redirect target URL.
     *
     * @return string
     */
	public function getRedirectUrl()
	{
		return $this->data['redirectUrl'];
	}

	/**
	 * Get transaction reference
	 *
	 * @return string
	 */
	public function getTransactionReference()
    {
        return $this->data['transactionReference'];
    }
}
