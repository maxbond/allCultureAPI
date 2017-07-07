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

class Api extends ApiActions
{
    use Dates;

    /**
     * API version
     */
    const API_VERSION = 2.2;

    /**
     * API base url.
     */
    const API_URL = 'https://all.culture.ru/api/' . self::API_VERSION;

    /**
     * API image storage URL.
     */
    const UPLOADS_URL = 'https://all.culture.ru/uploads/';


    /**
     * Status for request filter.
     */
    const ALLOWED_STATUSES = [
        'accepted',
        'new',
        'rejected',
    ];

    /**
     * Types for categories.
     */
    const CATEGORIES_TYPES = [
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
     */
    CONST OUTPUT_FORMATS = [
        'json',
        'csv',
    ];

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
     * Api constructor.
     *
     * @param RequestInterface $requester
     */
    public function __construct(RequestInterface $requester)
    {
        $this->requester = $requester;
        $this->params = [];
        $this->sort = [];
    }

    /**
     * Get one event API method.
     *
     * @param $id
     *
     * @return object
     */
    public function getEvent(int $id) : object
    {
        $this->validate();
        $this->url = self::API_URL . '/events/'.$id;

        return $this->fire();
    }

    /**
     * Get events API method.
     *
     * @return object
     */
    public function getEvents() : object
    {
        $this->validate();
        $this->url = self::API_URL . '/events?';

        return $this->fire();
    }

    /**
     * Get articles API method.
     *
     * @return object
     */
    public function getArticles() : object
    {
        $this->validate();
        $this->url = self::API_URL . '/articles?';

        return $this->fire();
    }

    /**
     * Get categories API method.
     *
     * @return object
     */
    public function getCategories() : object
    {
        $this->validate();
        $this->url = self::API_URL . '/categories?';

        return $this->fire();
    }

    /**
     * Get tags API method.
     *
     * @return object
     */
    public function getTags() : object
    {
        $this->validate();
        $this->url = self::API_URL . '/tags?';

        return $this->fire();
    }

    /**
     * Get locales API method.
     *
     * @return object
     */
    public function getLocales() : object
    {
        $this->validate();
        $this->url = self::API_URL . '/locales?';

        return $this->fire();
    }

    /**
     * Get organizations API method.
     *
     * @return object
     */
    public function getOrganizations() : object
    {
        $this->validate();
        $this->url = self::API_URL . '/organizations?';

        return $this->fire();
    }

    /**
     * Get places API method.
     *
     * @return object
     */
    public function getPlaces() : object
    {
        $this->validate();
        $this->url = self::API_URL . '/places?';

        return $this->fire();
    }

    /**
     * Get one place API method.
     *
     * @param $id
     *
     * @return object
     */
    public function getPlace(int $id) : object
    {
        $this->validate();
        $this->url = self::API_URL . '/places/'.$id;

        return $this->fire();
    }

    /**
     * Add custom parameter to request.
     *
     * @param $param
     * @param $value
     */
    public function addCustomParam(string $param, $value)
    {
        $this->params[$param] = $value;
    }

    /**
     * Set IDs filter.
     *
     * @param array $ids
     */
    public function setIDs(array $ids)
    {
        $this->params['ids'] = $ids;
    }

    /**
     * Add location.
     *
     * @param array $locales
     */
    public function setLocales(array $locales)
    {
        $this->params['locales'] = $locales;
    }

    /**
     * Add place.
     *
     * @param array $places
     */
    public function setPlaces(array $places)
    {
        $this->params['places'] = $places;
    }

    /**
     * Add subordination.
     *
     * @param array $subordinations
     */
    public function setSubordinations(array $subordinations)
    {
        $this->params['subordinations'] = $subordinations;
    }

    /**
     * Add strict subordination.
     *
     * @param array $strictSubordinations
     */
    public function setStrictSubordinations(array $strictSubordinations)
    {
        $this->params['strictSubordinations'] = $strictSubordinations;
    }

    /**
     * Add organization.
     *
     * @param array $organizations
     */
    public function setOrganizations(array $organizations)
    {
        $this->params['organizations'] = $organizations;
    }

    /**
     * Add field filter to request.
     *
     * @param array $fields
     */
    public function setFilterByFields(array $fields)
    {
        $this->params['fields'] = $fields;
    }

    /**
     * Add limit.
     *
     * @param int $limit
     * @param int $offset
     */
    public function setLimit(int $limit, $offset = 0)
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
    public function addSortField(string $field, $descending = false)
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
     */
    public function setStatus(string $status)
    {
        $this->params['status'] = $status;
    }

    /**
     * Start from.
     *
     * @param string $start
     */
    public function setStart(string $start)
    {
        $this->params['start'] = $this->getTimestamp($start);
    }

    /**
     * End at.
     *
     * @param string $end
     */
    public function setEnd(string $end)
    {
        $this->params['end'] = $this->getTimestamp($end);
    }

    /**
     * Created at date start.
     *
     * @param string $dateStart
     */
    public function setCreateDateStart(string $dateStart)
    {
        $this->params['createDateStart'] = $this->getTimestamp($dateStart);
    }

    /**
     * Created at date end.
     *
     * @param string $dateEnd
     */
    public function setCreateDateEnd(string $dateEnd)
    {
        $this->params['createDateEnd'] = $this->getTimestamp($dateEnd);
    }

    /**
     * Add search query part.
     *
     * @param string $query
     */
    public function setNameQuery(string $query)
    {
        $this->params['nameQuery'] = urlencode($query);
    }

    /**
     * Set type.
     *
     * @param $type
     */
    public function setType($type)
    {
        $this->params['type'] = $type;
    }

    /**
     * Set output format csv or json.
     *
     * @param $format
     */
    public function setFormat(string $format)
    {
        $this->params['format'] = $format;
    }

    /**
     * With integration.
     *
     * @param string $integration
     */
    public function setWithIntegration(string $integration)
    {
        $this->params['withIntegration'] = $integration;
    }

    /**
     * Set sourceId.
     *
     * @param int $sourceId
     */
    public function setInSourceId(int $sourceId)
    {
        $this->params['inSourceId'] = $sourceId;
    }

    /**
     * onlyIntegrated ?
     *
     * @param bool $onlyIntegrated
     */
    public function setOnlyIntegrated(bool $onlyIntegrated)
    {
        if (true === $onlyIntegrated) {
            $this->params['onlyIntegrated'] = 'true';
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
     * @return string
     */
    public function getAPIVersion() : string
    {
        return self::API_VERSION;
    }

    /**
     * Get allowed statuses.
     *
     * @return array
     */
    public function getStatuses() : array
    {
        return self::ALLOWED_STATUSES;
    }

    /**
     * Get allowed types.
     *
     * @return array
     */
    public function getTypes() : array
    {
        return self::CATEGORIES_TYPES;
    }

    /**
     * Get image url by name
     * API can resize image to some width and height.
     *
     * @param string $imageName   image file name from request
     * @param int    $width  image width
     * @param int    $height image height
     *
     * @return string
     */
    public function getImageUrl(string $imageName, int $width = null, int $height = null) : string
    {
        if ($width !== null && $height !== null) {
            $fileName = pathinfo($imageName, PATHINFO_FILENAME);
            $extension = pathinfo($imageName, PATHINFO_EXTENSION);
            $imageName = $fileName.'_w'.$width.'_h'.$height.'.'.$extension;
        }

        return self::UPLOADS_URL . $imageName;
    }



    /**
     * Validate type, format, status params.
     *
     * @throws \Exception
     */
    protected function validate()
    {
        // Type mus be one from $this->types
        if (!empty($this->params['type'])) {
            if (!in_array($this->params['type'], self::CATEGORIES_TYPES)) {
                throw new \Exception('Unknown category '
                    .$this->params['type'].'. Must be one from list: '.implode(',', self::CATEGORIES_TYPES));
            }
        }
        // Format must be one from $this->formats
        if (!empty($this->params['format'])) {
            if (!in_array($this->params['format'], self::OUTPUT_FORMATS)) {
                throw new \Exception('Unknown format '
                    .$this->params['format'].'. Must be one from list: '
                    .implode(',', self::OUTPUT_FORMATS));
            }
        }
        //Status must be one from list $this->allowedStatuses
        if (!empty($this->params['status'])) {
            if (!in_array($this->params['status'], self::ALLOWED_STATUSES)) {
                throw new \Exception('Wrong status. Here allowed one from list - '
                    .implode(',', self::ALLOWED_STATUSES));
            }
        }
    }

    /**
     * Build and return full request url.
     *
     * @throws \Exception
     *
     * @return string
     */
    protected function getRequestUrl() : string
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

        return $this->url . $preparedUrl;
    }
}
