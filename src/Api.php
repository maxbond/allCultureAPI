<?php
/**
 * Class Api.
 *
 * all.culture.ru API wrapper
 *
 * @author Maxim Bondarev <macintosh.way@gmail.com>
 *
 * @link https://all.culture.ru/public/json/howitworks
 */

namespace Maxbond\AllCultureAPI;

class Api
{    
    const API_VERSION = 2.2;

    /**
     * Request object
     * Must contain doRequest($url) method.
     *
     * @var
     */
    protected $requester;
    
    /**
     * Sort fields array.
     *
     * @var array
     */
    protected $sort;
    
    /**
     * Request URL.
     *
     * @var string
     */
    protected $url = '';
    
    /**
     * Http get params.
     *
     * @var array
     */
    protected $params;
    
    /**
     * API base url.
     *
     * @var string
     */
    protected $apiUrl = 'https://all.culture.ru/api/2.2/';
    
    /**
     * API image storage URL.
     *
     * @var string
     */
    protected $uploadsUrl = 'https://all.culture.ru/uploads/';

    public function __construct($requester)
    {
        $this->requester = $requester;
        $this->params = [];
        $this->sort = [];
    }

    /**
     * Status for request filter.
     *
     * @var array
     */
    protected $allowedStatuses = [
        'accepted',
        'new',
        'rejected',
    ];

    /**
     * Types for categories.
     *
     * @var array
     */
    protected $types = [
        'events',
        'articles',
        'categories',
        'tags',
        'locales',
        'organizations',
        'places',
    ];

    /**
     * Output formats for articles and places.
     *
     * @var array
     */
    protected $formats = [
        'json',
        'csv',
    ];

    /**
     * Get one event API method.
     *
     * @param $id
     * @return object
     */
    public function getEvent($id)
    {
        $this->validate();
        $this->url = $this->apiUrl.'events/'.$id;
        return $this->fire();
    }

    /**
     * Get events API method.
     *
     * @return object
     */
    public function getEvents()
    {
        $this->validate();
        $this->url = $this->apiUrl.'events?';
        return $this->fire();
    }

    /**
     * Get articles API method.
     *
     * @return object
     */
    public function getArticles()
    {
        $this->validate();
        $this->url = $this->apiUrl.'articles?';
        return $this->fire();
    }

    /**
     * Get categories API method.
     *
     * @return object
     */
    public function getCategories()
    {
        $this->validate();
        $this->url = $this->apiUrl.'categories?';
        return $this->fire();
    }

    /**
     * Get tags API method.
     *
     * @return object
     */
    public function getTags()
    {
        $this->validate();
        $this->url = $this->apiUrl.'tags?';
        return $this->fire();
    }

    /**
     * Get locales API method.
     *
     * @return object
     */
    public function getLocales()
    {
        $this->validate();
        $this->url = $this->apiUrl.'locales?';
        return $this->fire();
    }

    /**
     * Get organizations API method.
     *
     * @return object
     */
    public function getOrganizations()
    {
        $this->validate();
        $this->url = $this->apiUrl.'organizations?';
        return $this->fire();
    }

    /**
     * Get places API method.
     *
     * @return object
     */
    public function getPlaces()
    {
        $this->validate();
        $this->url = $this->apiUrl.'places?';
        return $this->fire();
    }

    /**
     * Get one place API method.
     *
     * @param $id
     * @return object
     */
    public function getPlace($id)
    {
        $this->validate();
        $this->url = $this->apiUrl.'places/'.$id;
        return $this->fire();
    }

    /**
     * Add custom parameter to request.
     *
     * @param $param
     * @param $value
     */
    public function addCustomParam($param, $value)
    {
        $this->params[$param] = $value;
    }

    /**
     * Set IDs filter.
     *
     * @param array $ids
     *
     */
    public function setIDs($ids)
    {
        $this->params['ids'] = $ids;
    }

    /**
     * Add location.
     *
     * @param array $locales
     *
     */
    public function setLocales($locales)
    {
        $this->params['locales'] = $locales;
    }

    /**
     * Add place.
     *
     * @param array $places
     *
     */
    public function setPlaces($places)
    {
        $this->params['places'] = $places;
    }

    /**
     * Add subordination.
     *
     * @param array $subordinations
     *
     */
    public function setSubordinations($subordinations)
    {
        $this->params['subordinations'] = $subordinations;
    }

    /**
     * Add strict subordination.
     *
     * @param array $strictSubordinations
     *
     */
    public function setStrictSubordinations($strictSubordinations)
    {
        $this->params['strictSubordinations'] = $strictSubordinations;
    }

    /**
     * Add organization.
     *
     * @param array $organizations
     *
     */
    public function setOrganizations($organizations)
    {
        $this->params['organizations'] = $organizations;
    }

    /**
     * Add field filter to request.
     *
     * @param array $fields
     *
     */
    public function setFilterByFields($fields)
    {
        $this->params['fields'] = $fields;
    }

    /**
     * Add limit.
     *
     * @param int $limit
     * @param int $offset
     */
    public function setLimit($limit, $offset = 0)
    {
        $this->params['limit'] = $limit;
        $this->params['offset'] = $offset;
    }

    /**
     * Add sorting field.
     *
     * @param string $field
     * @param bool   $descending
     */
    public function addSortField($field, $descending = false)
    {
        if ($descending === true) {
            $this->sort[] = '-'.$field;
        } else {
            $this->sort[] = $field;
        }
    }

    /**
     * Add events status.
     *
     * @param $status
     *
     */
    public function setStatus($status)
    {
        $this->params['status'] = $status;
    }

    /**
     * Start from.
     *
     * @param string $start
     */
    public function setStart($start)
    {
        $this->params['start'] = $this->getTimestamp($start);
    }

    /**
     * End at.
     *
     * @param string $end
     */
    public function setEnd($end)
    {
        $this->params['end'] = $this->getTimestamp($end);
    }

    /**
     * Created at date start.
     *
     * @param string $dateStart
     */
    public function setCreateDateStart($dateStart)
    {
        $this->params['createDateStart'] = $this->getTimestamp($dateStart);
    }

    /**
     * Created at date end.
     *
     * @param string $dateEnd
     */
    public function setCreateDateEnd($dateEnd)
    {
        $this->params['createDateEnd'] = $this->getTimestamp($dateEnd);
    }

    /**
     * Add search query part.
     *
     * @param string $query
     */
    public function setNameQuery($query)
    {
        $this->params['nameQuery'] = urlencode($query);
    }

    /**
     * Set type.
     *
     * @param $type
     *
     */
    public function setType($type)
    {
        $this->params['type'] = $type;
    }

    /**
     * Set uoutput format csv or json.
     *
     * @param $format
     *
     */
    public function setFormat($format)
    {
        $this->params['format'] = $format;
    }

    /**
     * With integration.
     *
     * @param string $integration
     */
    public function setWithIntegration($integration)
    {
        $this->params['withIntegration'] = $integration;
    }

    /**
     * Set sourceId.
     *
     * @param int $sourceId
     */
    public function setInSourceId($sourceId)
    {
        $this->params['inSourceId'] = $sourceId;
    }

    /**
     * onlyIntegrated ?
     *
     * @param bool $onlyIntegrated
     */
    public function setOnlyIntegrated($onlyIntegrated)
    {
        if (true === $onlyIntegrated) {
            $this->params['onlyIntegrated'] = 'true';
        }
    }

    /**
     * Validate type, format, status params
     *
     * @throws \Exception
     */
    public function validate()
    {
        // Type mus be one from $this->types
        if(!empty($this->params['type'])) {
            if (!in_array($this->params['type'], $this->types)) {
                throw new \Exception('Unknown category '
                    . $this->params['type'] . '. Must be one from list: ' . implode(',', $this->types));
            }
        }
        // Format must be one from $this->formats
        if(!empty($this->params['format'])) {
            if (!in_array($this->params['format'], $this->formats)) {
                throw new \Exception('Unknown format '
                    .$this->params['format'].'. Must be one from list: '
                    .implode(',', $this->formats));
            }
        }
        //Status must be one from list $this->allowedStatuses
        if(!empty($this->params['status'])) {
            if (!in_array($this->params['status'], $this->allowedStatuses)) {
                throw new \Exception('Wrong status. Here allowed one from list - '
                    .implode(',', $this->allowedStatuses));
            }
        }
    }

    /**
     * Reset all parameters and response.
     */
    public function reset()
    {
        $this->params = [];
        $this->sort = [];
        $this->url = '';
    }

    /**
     * Return API version.
     *
     * @return int
     */
    public function getAPIVersion()
    {
        return self::API_VERSION;
    }

    /**
     * Get allowed statuses.
     *
     * @return array
     */
    public function getStatuses()
    {
        return $this->allowedStatuses;
    }

    /**
     * Get allowed types.
     *
     * @return array
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * Get image url by name
     * API can resize image to some width and height.
     *
     * @param string $name   image file name from request
     * @param int    $width  image width
     * @param int    $height image height
     *
     * @return string
     */
    public function getImageUrl($name, $width = null, $height = null)
    {
        if ($width !== null && $height !== null) {
            $fileName = pathinfo($name, PATHINFO_FILENAME);
            $extension = pathinfo($name, PATHINFO_EXTENSION);
            $name = $fileName.'_w'.$width.'_h'.$height.'.'.$extension;
        }

        return $this->uploadsUrl.$name;
    }

    /**
     * Convert timestamp to formatted date.
     *
     * @param $timestamp
     * @param $format
     *
     * @return string
     */
    public function getDate($timestamp, $format)
    {
        $dateTime = new \DateTime();
        $dateTime->setTimestamp($timestamp / 1000);

        return $dateTime->format($format);
    }

    /**
     * Get timestamp from date.
     *
     * @param $date
     *
     * @return int
     */
    public function getTimestamp($date)
    {
        $dateTime = new \DateTime($date);

        return $dateTime->getTimestamp() * 1000;
    }

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
