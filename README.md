# AllCultureAPI
PHP API wrapper for russian culture events database all.culture.ru 

## Usage:
install via composer: composer require maxbond/allcultureapi
    
    use Maxbond\AllCultureAPI\Api;
    use Maxbond\AllCultureAPI\CurlRequest;
            
    $api = new Api(new CurlRequest);
            
    $dateTime = new DateTime();
    $periodStart = $dateTime->format('Y-m-d');
    $dateTime->add(new DateInterval('P1D'));
    $periodEnd = $dateTime->format('Y-m-d');
            
    //Set limit to 10 events
    $api->setLimit(10);
        
    //Events from date    
    $api->setStart($periodStart);
        
    //Events to date
    $api->setEnd($periodEnd);
        
    try {
        $events = $api->getEvents();
    } catch (Exception $e) {
        echo 'error:'.$e->getMessage();
    }
        
    var_dump($events);