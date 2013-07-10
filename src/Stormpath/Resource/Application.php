<?php

namespace Stormpath\Resource;

use Stormpath\Resource\AbstractResource;
use Stormpath\Service\StormpathService;
use Stormpath\Collections\ResourceCollection;
use Zend\Http\Client;
use Zend\Json\Json;

class Application extends AbstractResource
{
    protected $name;
    protected $description;
    protected $status;
    protected $tenant;
    protected $accounts;
    protected $groups;
    protected $loginAttempts;
    protected $passwordResetTokens;

    public function getName()
    {
        $this->_load();
        return $this->name;
    }

    public function setName($value)
    {
        $this->_load();
        $this->name = $value;
        return $this;
    }

    public function getDescription()
    {
        $this->_load();
        return $this->description;
    }

    public function setDescription($value)
    {
        $this->_load();
        $this->description = $value;
        return $this;
    }

    public function getStatus()
    {
        $this->_load();
        return $this->status;
    }

    public function setStatus($value)
    {
        $this->_load();
        $this->status = $value;
        return $this;
    }

    public function setTenant(Tenant $value)
    {
        $this->_load();
        $this->tenant = $value;
        return $this;
    }

    public function getTenant()
    {
        $this->_load();
        return $this->tenant;
    }

    public function setAccounts(ResourceCollection $value)
    {
        $this->_load();
        $this->accounts = $value;
        return $this;
    }

    public function getAccounts()
    {
        $this->_load();
        return $this->accounts;
    }

    public function setGroups(ResourceCollection $value)
    {
        $this->_load();
        $this->groups = $value;
        return $this;
    }

    public function getGroups()
    {
        $this->_load();
        return $this->groups;
    }

    public function setLoginAttempts(ResourceCollection $value)
    {
        $this->_load();
        $this->loginAttempts = $value;
        return $this;
    }

    public function getLoginAttempts()
    {
        $this->_load();
        return $this->loginAttempts;
    }

    public function setPasswordResetTokens(ResourceCollection $value)
    {
        $this->_load();
        $this->passwordResetTokens = $value;
        return $this;
    }

    public function getPasswordResetTokens()
    {
        $this->_load();
        return $this->passwordResetTokens;
    }

    public function exchangeArray($data)
    {
        $this->setHref(isset($data['href']) ? $data['href']: null);
        $this->setName(isset($data['name']) ? $data['name']: null);
        $this->setDescription(isset($data['description']) ? $data['description']: null);
        $this->setStatus(isset($data['status']) ? $data['status']: null);

        $tenant = new \Stormpath\Resource\Tenant;
        $tenant->_lazy($this->getResourceManager(), substr($data['tenant']['href'], strrpos($data['tenant']['href'], '/') + 1));

        $this->setTenant($tenant);

        $this->setAccounts(new ResourceCollection($this->getResourceManager(), 'Stormpath\Resource\Account', $data['accounts']['href']));
        $this->setGroups(new ResourceCollection($this->getResourceManager(), 'Stormpath\Resource\Group', $data['groups']['href']));
        $this->setLoginAttempts(new ResourceCollection($this->getResourceManager(), 'Stormpath\Resource\LoginAttempt', $data['loginAttempts']['href']));
        $this->setPasswordResetTokens(new ResourceCollection($this->getResourceManager(), 'Stormpath\Resource\PasswordResetToken', $data['passwordResetTokens']['href']));

    }

    public function getArrayCopy()
    {
        $this->_load();

        return array(
            'href' => $this->getHref(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'status' => $this->getStatus(),
        );
    }
/*
    public function registerApplication($options = array())
    {
        if (!ApiKey::getAccessId())
            throw new \Exception('Get an API key');

        $http = new Client();
        $http->setUri(StormpathService::BASEURI .'/applications/'. ApiKey::getAccessId());
        $http->setOptions(array('sslverifypeer' => false));
        $http->setMethod('POST');

        $options['name'] = self::getName();
        $options['description'] = self::getDescription();
        $options['status'] = self::getStatus();
        $http->setParameterGet($options);

        $response = $http->send();
        return Json::decode($response->getBody());

    }
*/
}
