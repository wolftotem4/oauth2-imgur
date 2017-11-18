<?php

namespace Tests\Unit\Provider;

use WTotem4\OAuth2\Client\Provider\ImgurUser;

class ImgurUserTest extends \PHPUnit_Framework_TestCase
{
    public function testUserData()
    {
        $faker = \Faker\Factory::create();

        $id             = random_int(1000, 1000000);
        $url            = $faker->url;
        $bio            = $faker->sentence;
        $reputation     = random_int(100000, 1000000000) / 100;
        $created        = time();
        $pro_expiration = time() + random_int(100, 1000);

        $data = compact('id', 'url', 'bio', 'reputation', 'created', 'pro_expiration');
        $user = new ImgurUser($data);

        $this->assertSame($id, $user->getId());
        $this->assertSame($url, $user->getUrl());
        $this->assertSame($bio, $user->getBio());
        $this->assertSame($reputation, $user->getReputation());
        $this->assertSame($created, $user->getCreated());
        $this->assertSame($pro_expiration, $user->getProExpiration());

        $this->assertEquals($data, $user->toArray());
    }
}
