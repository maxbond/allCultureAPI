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
    const CONNECTION_TIMEOUT = 3;
    const OPTION_HEADER = false;
    const OPTION_RETURN_TRANSFER = true;

    /**
     * Send HTTP request.
     *
     * @param string $url
     *
     * @throws \Exception
     *
     * @return string
     */
    public function doRequest(string $url): string
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, self::CONNECTION_TIMEOUT);
        curl_setopt($curl, CURLOPT_HEADER, self::OPTION_HEADER);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, self::OPTION_RETURN_TRANSFER);
        $response = curl_exec($curl);
        if (false === $response) {
            curl_close($curl);
            throw new \Exception("Can't get remote content: "
                . curl_error($curl));
        }
        curl_close($curl);

        return $response;
    }
}
