<?php

namespace FOSOpenScouting\Keeo;

use Curl;
use FOSOpenScouting\Keeo\Exception\BadRequestException;
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

        // verify secure connection
        $this->options['CURLOPT_SSL_VERIFYPEER'] = true;
        $this->options['CURLOPT_SSL_VERIFYHOST'] = 2;

        // set custom user agent
        $this->user_agent = 'fosopenscouting/keeo-api-wrapper ' . $this->config->getCurlUserAgent();
    }

    protected function setConfig(Config $config)
    {
        $this->config = $config;

        // (re)set auth now the config is set
        $this->setAuth($this->config->getApiUsername(), $this->config->getApiPassword());
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
                case '400': // Bad Request
                    throw new BadRequestException(self::extractErrorMessageFromResponseHeaders($response->headers));
                    break;
                case '401':
                    // Throw exception
                    throw new NotAuthenticatedException(self::extractErrorMessageFromResponseHeaders($response->headers));
                    break;
                case '500':
                    throw new InternalKeeoServerErrorException(self::extractErrorMessageFromResponseHeaders($response->headers));
                    break;
                default:
                    break;
            }
        } else {
            throw new InvalidResponseException('Status code not set');
        }
    }

    /**
     * @param array $headers
     * @return string
     */
    public static function extractErrorMessageFromResponseHeaders(array $headers)
    {
        $errorMessage = '';

        // Use json message if set
        if (empty($errorMessage) && isset($headers['X-Json'])) {
            // remove the brackets at the start and end of the json string
            $jsonResponse = substr($headers['X-Json'], 1, -1);
            // decode json
            $jsonResponse = json_decode($jsonResponse, true);

            if (isset($jsonResponse['message'])) {
                $errorMessage = $jsonResponse['message'];
            }
        }

        // Maybe the www authenticate error?
        if (empty($errorMessage) && isset($headers['WWW-Authenticate'])) {
            $errorMessage = $headers['WWW-Authenticate'];
        }

        // last change, just use the default status message
        if (empty($errorMessage) && isset($headers['Status'])) {
            $errorMessage = $headers['Status'];
        }

        return $errorMessage;
    }
}
