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
     * Sort fields array.
     *
     * @var array
     */
    protected $sort;
        
    
    /**
     * Http get params.
     *
     * @var array
     */
    protected $params;

	/**
     * Request URL.
     *
     * @var string
     */
    protected $url = '';

    /**
     * Request object
     * Must contain doRequest($url) method.
     *
     * @var RequestInterface
     */
    protected $requester;

    /**
     * Build and return full request url.
     *
     * @return string
     *
     * @throws \Exception
     */
    protected function getRequestUrl()
    {
        if ($this->url === '') {
            throw new \Exception('API method must be set.');
        }
        if (!empty($this->sort)) {
            $this->params['sort'] = $this->sort;
        }
        $preparedUrl = '';
        foreach ($this->params as $key => $param) {
            if (is_array($param)) {
                $preparedUrl .= $key.'='.implode(',', $param);
            } else {
                $preparedUrl .= $key.'='.$param;
            }
            $preparedUrl .= '&';
        }
        $preparedUrl = substr($preparedUrl, 0, -1);

        return $this->url.$preparedUrl;
    }

    /**
     * Do request and return response.
     *
     * @return object
     *
     * @throws \Exception
     */
    protected function fire()
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
            if(isset($jsonResponse->error)) {
                throw new \Exception('API error: '.$jsonResponse->error);
            }
            return $jsonResponse;
        }
        throw new \Exception('Empty response');
    }

}