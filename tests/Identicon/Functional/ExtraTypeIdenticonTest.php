<?php

namespace Identicon\Tests;

class ExtraTypeIdenticonTest extends AbstractTypeIdenticonTest
{
    public function testPlainPage()
    {
        $client = $this->createClient();
        $client->request("GET", "/identity/plain.png");
        $response = $client->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertImageIsCorrect($response, "identity-plain.png");
        $this->assertEquals('inline; filename="identity.png"', $response->headers->get("Content-Disposition"));
    }

    public function testTrianglePage()
    {
        $client = $this->createClient();
        $client->request("GET", "/identity/pyramid.png");
        $response = $client->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertImageIsCorrect($response, "identity-pyramid.png");
    }

    public function testCirclePage()
    {
        $client = $this->createClient();
        $client->request("GET", "/identity/circle.png");
        $response = $client->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertImageIsCorrect($response, "identity-circle.png");
    }

    public function testRhombusPage()
    {
        $client = $this->createClient();
        $client->request("GET", "/identity/rhombus.png");
        $response = $client->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertImageIsCorrect($response, "identity-rhombus.png");
    }


    public function testUnknownTypePage()
    {
        $client = $this->createClient();
        $client->request("GET", "/identity/unknown.png");
        $response = $client->getResponse();

        $this->assertTrue($response->isClientError(), $response->getStatusCode());
    }

    public function testCachedExtraType()
    {
        $client = $this->createClient();
        $client->request("GET", "/identity/circle.png");
        $response = $client->getResponse();
        $this->assertTrue($response->isCacheable());
        $this->assertEquals(3600, $response->getMaxAge());
        $this->assertTrue($response->isValidateable());
    }

    public function testUnknownFormat()
    {
        $client = $this->createClient();
        $client->request("GET", "/identity/pyramid.jpg");
        $response = $client->getResponse();

        $this->assertTrue($response->isClientError());
    }
}