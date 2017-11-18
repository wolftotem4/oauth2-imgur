<?php

namespace WTotem4\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class ImgurUser implements ResourceOwnerInterface
{
    /**
     * @var array
     */
    protected $data;

    /**
     * ImgurUser constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->getField('id');
    }

    /**
     * @return string|null
     */
    public function getUrl()
    {
        return $this->getField('url');
    }

    /**
     * @return string|null
     */
    public function getBio()
    {
        return $this->getField('bio');
    }

    /**
     * @return float|null
     */
    public function getReputation()
    {
        return $this->getField('reputation');
    }

    /**
     * @return int|null
     */
    public function getCreated()
    {
        return $this->getField('created');
    }

    /**
     * @return int|bool|null
     */
    public function getProExpiration()
    {
        return $this->getField('pro_expiration');
    }

    /**
     * Returns all the data obtained about the user.
     *
     * @return array
     */
    public function toArray()
    {
        return isset($this->data) ? $this->data : array();
    }

    /**
     * @param string $key
     *
     * @return mixed|null
     */
    private function getField($key)
    {
        return isset($this->data[$key]) ? $this->data[$key] : null;
    }
}