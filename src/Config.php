<?php

namespace FOSOpenScouting\Keeo;

use FOSOpenScouting\Keeo\Exception\ConfigIntegrityException;

class Config
{
    protected $apiUrl = 'https://keeo.fos.be/api';
    protected $apiUsername;
    protected $apiPassword;
    protected $userLoginSalt;
    protected $curlUserAgent = '';

    public function __construct(array $configArray) {
        $this->parseArray($configArray);
    }

    /**
     * @return string
     */
    public function getApiUrl()
    {
        return $this->apiUrl;
    }

    /**
     * @return string
     */
    public function getApiUsername()
    {
        return $this->apiUsername;
    }

    /**
     * @return string
     */
    public function getApiPassword()
    {
        return $this->apiPassword;
    }

    /**
     * @return string
     */
    public function getUserLoginSalt()
    {
        return $this->userLoginSalt;
    }

    /**
     * @return string
     */
    public function getCurlUserAgent()
    {
        return $this->curlUserAgent;
    }

    /**
     * @param array $configArray
     */
    protected function parseArray(array $configArray)
    {
        foreach ($configArray as $key => $value) {
            $this->{'set' . ucfirst($key)}($value);
        }

        $this->testIntegrity();
    }

    /**
     * @param string $apiUrl
     */
    protected function setApiUrl($apiUrl)
    {
        $this->apiUrl = $apiUrl;
    }

    /**
     * @param string $apiUsername
     */
    protected function setApiUsername($apiUsername)
    {
        $this->apiUsername = $apiUsername;
    }

    /**
     * @param string $apiPassword
     */
    protected function setApiPassword($apiPassword)
    {
        $this->apiPassword = $apiPassword;
    }

    /**
     * @param string $userLoginSalt
     */
    protected function setUserLoginSalt($userLoginSalt)
    {
        $this->userLoginSalt = $userLoginSalt;
    }

    /**
     * @param string $curlUserAgent
     */
    protected function setCurlUserAgent($curlUserAgent)
    {
        $this->curlUserAgent = $curlUserAgent;
    }

    /**
     * Test if every config variable has a value, throws an error if not
     *
     * @throws ConfigIntegrityException
     */
    protected function testIntegrity()
    {
        // get var names
        $vars = array_keys(get_class_vars(get_class($this)));

        // check every variable if it is filled in
        foreach ($vars as $var) {
            if (is_null($this->{$var})) {
                throw new ConfigIntegrityException('There is no config value set for \'' . $var . '\'');
            }
        }
    }
}