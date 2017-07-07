<?php
/**
 * Class ApiActions.
 *
 * all.culture.ru API wrapper
 *
 * @author Maxim Bondarev <macintosh.way@gmail.com>
 *
 * @link https://all.culture.ru/public/json/howitworks
 */

namespace Maxbond\AllCultureAPI;

abstract class ApiActions
{
    /**
     * Request object
     * Must contain doRequest($url) method.
     *
     * @var RequestInterface
     */
    protected $requester;

    /**
     * Build and return full request url.
     */
    abstract protected function getRequestUrl();

    /**
     * Do request and return response.
     *
     * @throws \Exception
     *
     * @return object
     */
    protected function fire() : object
    {
        $response = null;
        try {
            $url = $this->getRequestUrl();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        try {
            $response = $this->requester->doRequest($url);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        if ($response) {
            $jsonResponse = json_decode($response);
            if (isset($jsonResponse->error)) {
                throw new \Exception('API error: '.$jsonResponse->error);
            }

            return $jsonResponse;
        }
        throw new \Exception('Empty response');
    }
}
