<?php

namespace Tests\Unit\Provider;

use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;
use WTotem4\OAuth2\Client\Provider\Imgur;

class FooImgurProvider extends Imgur
{
    protected function fetchResourceOwnerDetails(AccessToken $token)
    {
        return [
            'data' => [
                'id'             => 'mock_id',
                'url'            => 'http://mock_url',
                'bio'            => 'mock_bio',
                'reputation'     => 'mock_reputation',
                'created'        => 'mock_created',
                'pro_expiration' => 'mock_pro_expiration',
            ],
        ];
    }

    public function callCheckResponse(...$args)
    {
        $this->checkResponse(...$args);
    }
}

class ImgurTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FooImgurProvider
     */
    protected $provider;

    /**
     * @var \Mockery\MockInterface|\League\OAuth2\Client\Token\AccessToken
     */
    protected $token;

    /**
     * @var \Mockery\MockInterface|\Psr\Http\Message\ResponseInterface
     */
    protected $responseMock;

    protected function setUp()
    {
        parent::setUp();

        $this->provider = new FooImgurProvider([
            'clientId' => 'mock_client_id',
            'clientSecret' => 'mock_secret',
            'redirectUri' => 'none',
        ]);

        $this->token = \Mockery::mock(AccessToken::class);

        $this->responseMock = \Mockery::mock(ResponseInterface::class);
    }

    protected function tearDown()
    {
        \Mockery::close();

        parent::tearDown();
    }

    public function testUserData()
    {
        $userData = $this->provider->getResourceOwner($this->token);

        $this->assertEquals('mock_id', $userData->getId());
        $this->assertEquals('http://mock_url', $userData->getUrl());
        $this->assertEquals('mock_bio', $userData->getBio());
        $this->assertEquals('mock_reputation', $userData->getReputation());
        $this->assertEquals('mock_created', $userData->getCreated());
        $this->assertEquals('mock_pro_expiration', $userData->getProExpiration());
    }

    /**
     * @expectedException        \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     * @expectedExceptionCode    400
     * @expectedExceptionMessage An OAuth Error
     */
    public function testProperlyHandlesErrorResponses()
    {
        $code     = 400;
        $message  = 'An OAuth Error';
        $response = ['data' => ['error' => $message]];

        $this->responseMock
            ->shouldReceive('getStatusCode')
            ->once()
            ->withNoArgs()
            ->andReturn($code);

        $this->provider->callCheckResponse($this->responseMock, $response);
    }
}
