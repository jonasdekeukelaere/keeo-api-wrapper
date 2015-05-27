<?php

namespace FOSOpenScouting\Keeo;

use Curl;
use FOSOpenScouting\Keeo\Exception\NotAuthenticatedException;

class KeeoConnector extends Curl
{
    /**
     * @var Config
     */
    protected $config;

    public function __construct(Config $config)
	{
        $this->setConfig($config);

		parent::__construct();

		$this->options['CURLOPT_SSL_VERIFYPEER'] = false;
		$this->options['CURLOPT_SSL_VERIFYHOST'] = false;
		$this->setAuth($this->config->getApiUsername(), $this->config->getApiPassword());
	}

    protected function setConfig(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param string $url
     * @param array $vars
     * @return \CurlResponse
     * @throws NotAuthenticatedException
     */
	function get($url, $vars = array())
	{
		$response = parent::get($this->config->getApiUrl() . $url, $vars);

        $this->checkResponse($response);

        return $response;
	}

    /**
     * @param string $url
     * @param array $vars
     * @return bool|\CurlResponse
     * @throws NotAuthenticatedException
     */
	function post($url, $vars = array())
	{
		$response = parent::post($this->config->getApiUrl() . $url, $vars);

        $this->checkResponse($response);

        return $response;
	}

    /**
     * @param $response
     * @throws NotAuthenticatedException
     */
    protected function checkResponse($response)
    {
        $this->isAuthenticated($response);
    }

    /**
     * @param $response
     * @throws NotAuthenticatedException
     * @return bool
     */
    protected function isAuthenticated($response)
    {
        if ($response->headers['Status-Code'] == '401') {
            // Throw exception
            throw new NotAuthenticatedException(isset($response->headers['["WWW-Authenticate"]']) ? $response->headers['["WWW-Authenticate"]'] : '');
        }

        return true;
    }
}