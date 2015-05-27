<?php

namespace FOSOpenScouting\Keeo;

use FOSOpenScouting\Keeo\Exception\ConfigIntegrityException;

class Config
{
    protected $apiUrl = 'https://api.fos.be';
    protected $apiUsername;
    protected $apiPassword;
    protected $userLoginSalt;

    public function __construct(array $configArray) {
        $this->parseArray($configArray);
    }

    /**
     * @return mixed
     */
    public function getApiUrl()
    {
        return $this->apiUrl;
    }

    /**
     * @return mixed
     */
    public function getApiUsername()
    {
        return $this->apiUsername;
    }

    /**
     * @return mixed
     */
    public function getApiPassword()
    {
        return $this->apiPassword;
    }

    /**
     * @return mixed
     */
    public function getUserLoginSalt()
    {
        return $this->userLoginSalt;
    }

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

    protected function testIntegrity()
    {
        // get var names
        $vars = array_keys(get_class_vars(get_class($this)));

        // check every variable if it is filled in
        foreach ($vars as $var) {
            if (empty($this->{$var})) {
                throw new ConfigIntegrityException('There is no config value set for \'' . $var . '\'');
            }
        }
    }
}