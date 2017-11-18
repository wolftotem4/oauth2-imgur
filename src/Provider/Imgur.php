<?php

namespace WTotem4\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Psr\Http\Message\ResponseInterface;

class Imgur extends AbstractProvider
{
    use BearerAuthorizationTrait;

    /**
     * @return string
     */
    public function getBaseAuthorizationUrl()
    {
        return 'https://api.imgur.com/oauth2/authorize';
    }

    /**
     * @param  array  $params
     * @return string
     */
    public function getBaseAccessTokenUrl(array $params)
    {
        return 'https://api.imgur.com/oauth2/token';
    }

    /**
     * @param  \League\OAuth2\Client\Token\AccessToken  $token
     * @return string
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        return 'https://api.imgur.com/3/account/me';
    }

    /**
     * @return array
     */
    protected function getDefaultScopes()
    {
        return [];
    }

    /**
     * @param  \Psr\Http\Message\ResponseInterface  $response
     * @param  array|string  $data
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     */
    protected function checkResponse(ResponseInterface $response, $data)
    {
        if (! empty($data['data']['error'])) {
            $code  = $response->getStatusCode();
            $error = $data['data']['error'];

            throw new IdentityProviderException($error, $code, $data);
        }
    }

    /**
     * @param  array  $response
     * @param  \League\OAuth2\Client\Token\AccessToken  $token
     * @return \WTotem4\OAuth2\Client\Provider\ImgurUser
     */
    protected function createResourceOwner(array $response, AccessToken $token)
    {
        $data = isset($response['data']) ? $response['data'] : array();
        return new ImgurUser($data);
    }
}