<?php
namespace Fitbase\Bundle\BarmerGekBundle\Service;

use Symfony\Component\DependencyInjection\ContainerAware;

class ServiceBarmerApi extends ContainerAware
{
    /**
     * Store api url here
     *
     * @var
     */
    protected $url;

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
    public function __construct($url, $client, $logger)
    {
        $this->url = $url;
        $this->client = $client;
        $this->logger = $logger;
    }

    /**
     * Get server url to do a requests
     *
     * @return string
     */
    protected function getUrl()
    {
        return $this->url;
    }

    /**
     * Get status for given session from barmer gek
     * @param null $id
     * @param null $key
     * @return bool
     */
    public function sessionStatus($id = null, $key = null)
    {
        $resource = "{$this->getUrl()}/sessionkey-sso/session-status?userId={$id}&sessionKey={$key}";

        if (($result = $this->process($resource))) {
            return $this->doConvertToBoolean($result->valid);
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
        $resource = "{$this->getUrl()}/sessionkey-sso/user?userId={$id}&userStatus=REGISTERED";

        if (($result = $this->process($resource, 'post'))) {
            return $this->doConvertToBoolean($result->success);
        }

        return false;
    }

    /**
     * Convert something to boolean
     * @param $value
     * @return bool
     */
    protected function doConvertToBoolean($value)
    {
        if (is_bool($value) || is_numeric($value)) {
            return (bool)$value;
        }

        if (is_string($value)) {
            return strtolower($value) == 'true' ? true : false;
        }

        return false;
    }

    /**
     * Do a client request
     *
     * @param $resource
     * @return mixed|null
     */
    protected function process($resource, $method = 'get')
    {
        try {

            $parameters = [$resource, 'payload'];
            if (in_array($method, ['get', 'delete'])) {
                $parameters = [$resource];
            }

            if (($response = call_user_func_array([$this->client, $method], $parameters))) {
                if ($response->getStatusCode() == 200) {

                    $this->logger->info($resource);
                    $this->logger->info($response->getContent());

                    return json_decode($response->getContent());
                }

                $this->logger->err($resource);
                $this->logger->err($response->getContent());
            }

        } catch (\Ci\RestClientBundle\Exceptions\CurlException $exception) {

            $this->logger->err($exception->getMessage());
        }

        return null;
    }


}