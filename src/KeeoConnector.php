<?php

namespace FOSOpenScouting\Keeo;

use Curl;
use FOSOpenScouting\Keeo\Exception\InternalKeeoServerErrorException;
use FOSOpenScouting\Keeo\Exception\InvalidResponseException;
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
        if (isset($response->headers['Status-Code'])) {
            switch ($response->headers['Status-Code']) {
                case '401':
                    // Throw exception
                    throw new NotAuthenticatedException(isset($response->headers['WWW-Authenticate']) ? $response->headers['WWW-Authenticate'] : '');
                    break;
                case '500':
                    throw new InternalKeeoServerErrorException(isset($response->headers['Status']) ? $response->headers['Status'] : '');
            }
        } else {
            throw new InvalidResponseException('Status code not set');
        }
    }
}