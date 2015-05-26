<?php

namespace FOSOpenScouting\Keeo;

use Curl;
use FOSOpenScouting\Keeo\Exception\NotAuthenticatedException;

class KeeoConnector extends Curl
{
	public function __construct()
	{
		parent::__construct();

		$this->options['CURLOPT_SSL_VERIFYPEER'] = false;
		$this->options['CURLOPT_SSL_VERIFYHOST'] = false;
		$this->setAuth(KEEO_API_USERNAME, KEEO_API_PASSWORD);
	}

    /**
     * @param string $url
     * @param array $vars
     * @return \CurlResponse
     * @throws NotAuthenticatedException
     */
	function get($url, $vars = array())
	{
		$response = parent::get(KEEO_API_URL.$url, $vars);

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
		$response = parent::post(KEEO_API_URL.$url, $vars);

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