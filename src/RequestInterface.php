<?php
/**
 * Interface RequestInterface.
 */

namespace Maxbond\AllCultureAPI;

interface RequestInterface
{
    public function doRequest(string $url): string;
}
