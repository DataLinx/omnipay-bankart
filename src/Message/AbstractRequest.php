<?php
namespace Omnipay\Bankart\Message;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
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
	 * Get common request data
	 *
	 * @return array
	 */
	public function getData()
	{
		$this->validate(
			'resourcePath',
			'terminalAlias'
		);

		return array(
			'resourcePath' => $this->getResourcePath(),
			'terminalAlias' => $this->getTerminalAlias(),
		);
	}
}
