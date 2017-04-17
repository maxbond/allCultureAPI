<?php
/**
 * Class CurlRequest.
 *
 * CURL request to api server
 *
 * @author Maxim Bondarev <macintosh.way@gmail.com>
 */

namespace Maxbond\AllCultureAPI;

class CurlRequest implements RequestInterface
{
    /**
     * Send HTTP request.
     *
     * @param string $url
     *
     * @throws \Exception
     *
     * @return string
     */
    public function doRequest($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        if (false === $response) {
            curl_close($curl);
            throw new \Exception("Can't get remote content: "
                .curl_error($curl));
        }
        curl_close($curl);

        return $response;
    }
}
