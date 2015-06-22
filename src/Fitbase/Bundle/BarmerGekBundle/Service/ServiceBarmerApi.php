<?php
namespace Fitbase\Bundle\BarmerGekBundle\Service;

use Symfony\Component\DependencyInjection\ContainerAware;

class ServiceBarmerApi extends ContainerAware
{
    /**
     * Object to create a http requests
     *
     * @var
     */
    protected $client;

    /**
     * Object to store logs
     *
     * @var
     */
    protected $logger;

    /**
     * Class constructor
     *
     * @param $client
     */
    public function __construct($client, $logger)
    {
        $this->client = $client;
        $this->logger = $logger;
    }

    /**
     * Get server url to do a requests
     *
     * @return string
     */
    protected function getServer()
    {
        return 'https://api.barmer-gek.de/cas-web/verifier/v1';
    }

    /**
     * Get status for given session from barmer gek
     * @param null $id
     * @param null $key
     * @return bool
     */
    public function sessionStatus($id = null, $key = null)
    {
        $resource = "{$this->getServer()}/sessionkey-sso/session-status?userId={$id}&sessionkey={$key}";

        if (($result = $this->process($resource))) {
            return $result->valid;
        }

        return false;
    }

    /**
     * Do request to Bermer to notify about fitbase registration
     *
     * @param null $id
     * @return bool
     */
    public function user($id = null)
    {
        $resource = "{$this->getServer()}/sessionkey-sso/user?userId={$id}&userStatus=REGISTERED";

        if (($result = $this->process($resource))) {
            return $result->success;
        }

        return false;
    }

    /**
     * Do a client request
     *
     * @param $resource
     * @return mixed|null
     */
    protected function process($resource)
    {
        try {

            if (($response = $this->client->get($resource))) {

                if ($response->getStatusCode() == 200) {
                    return json_decode($response->getContent());
                }

                $this->logger->err("BarmerGEK API response status: " . $response->getStatusCode());
            }

        } catch (Ci\RestClientBundle\Exceptions\CurlException $exception) {
            $this->logger->err($exception->getMessage());
        }

        return null;
    }


}