<?php
namespace Fitbase\Bundle\BarmerGekBundle\Tests\Service;


use Ci\RestClientBundle\Exceptions\CurlException;
use Fitbase\Bundle\BarmerGekBundle\Service\ServiceBarmerApi;
use Fitbase\Bundle\FitbaseBundle\Tests\FitbaseTestAbstract;
use Symfony\Component\HttpFoundation\Response;

class ServiceBarmerApiTest extends FitbaseTestAbstract
{

    /**
     * Get htpp client service mock for current object
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    public function getServiceClient()
    {
        $client = $this->getMock('ServiceClient', ['post', 'get']);


        return $client;
    }

    /**
     * Get service logger mock for current test
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    public function getServiceLogger()
    {
        $client = $this->getMock('ServiceLogger', ['err']);

        return $client;
    }

    public function testSessionStatusShouldReturnFailure()
    {
        $logger = $this->getServiceLogger();
        $client = $this->getServiceClient();
        $client->expects($this->any())
            ->method('get')->will($this->returnCallback(function () {
                throw new \Ci\RestClientBundle\Exceptions\CurlException('Just a test exception');
            }));

        $service = new ServiceBarmerApi($client, $logger);

        $this->assertFalse($service->sessionStatus('some_id', 'some_session_key'));
    }

    public function testSessionStatusShouldReturnFailureForCode401()
    {
        $logger = $this->getServiceLogger();
        $client = $this->getServiceClient();
        $client->expects($this->any())
            ->method('get')->will($this->returnCallback(function () {
                return new Response('{"valid": "true"}', 401);
            }));

        $service = new ServiceBarmerApi($client, $logger);

        $this->assertFalse($service->sessionStatus('some_id', 'some_session_key'));
    }

    public function testSessionStatusShouldReturnFailureForCode403()
    {
        $logger = $this->getServiceLogger();
        $client = $this->getServiceClient();
        $client->expects($this->any())
            ->method('get')->will($this->returnCallback(function () {
                return new Response('{"valid": "true"}', 403);
            }));

        $service = new ServiceBarmerApi($client, $logger);

        $this->assertFalse($service->sessionStatus('some_id', 'some_session_key'));
    }

    public function testSessionStatusShouldReturnFailureForCode404()
    {
        $logger = $this->getServiceLogger();
        $client = $this->getServiceClient();
        $client->expects($this->any())
            ->method('get')->will($this->returnCallback(function () {
                return new Response('{"valid": "true"}', 404);
            }));

        $service = new ServiceBarmerApi($client, $logger);

        $this->assertFalse($service->sessionStatus('some_id', 'some_session_key'));
    }

    public function testSessionStatusShouldReturnFailureForCode500()
    {
        $logger = $this->getServiceLogger();
        $client = $this->getServiceClient();
        $client->expects($this->any())
            ->method('get')->will($this->returnCallback(function () {
                return new Response('{"valid": "true"}', 500);
            }));

        $service = new ServiceBarmerApi($client, $logger);

        $this->assertFalse($service->sessionStatus('some_id', 'some_session_key'));
    }

    public function testSessionStatusShouldReturnTrue()
    {
        $logger = $this->getServiceLogger();
        $client = $this->getServiceClient();
        $client->expects($this->any())
            ->method('get')->will($this->returnCallback(function () {
                return new Response('{"valid": "true"}', 200);
            }));

        $service = new ServiceBarmerApi($client, $logger);

        $this->assertTrue($service->sessionStatus('some_id', 'some_session_key'));
    }

} 