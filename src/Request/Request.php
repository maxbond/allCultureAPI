<?php

namespace Maxbond\AllCultureAPI\Request;

/**
 * Class Request
 *
 * CURL request to api server
 *
 * @author Maxim Bondarev <macintosh.way@gmail.com>
 * @package Maxbond\AllCultureAPI\Request
 */
class Request
{

    /**
     * HTTP response
     */
    protected $response = '';
    
    /**
     * Send request and save to $this->response.
     * 
     * @param string $url
     * @throws \Exception
     */
    public function doRequest($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $this->response = curl_exec($curl);
        if (false === $this->response) {
            throw new \Exception("Can't get remote content: "
                .curl_error($curl));
        }
        curl_close($curl);
    }
}