# allCultureAPI
PHP API wrapper for russian culture events database all.culture.ru 

## Usage:
install via composer: composer require maxbond/allcultureapi
    
    $api = new Maxbond\AllCultureAPI\Api;
    $dateTime = new DateTime();
    $periodStart = $dateTime->format('Y-m-d');
    $dateTime->add(new DateInterval('P1D'));
    $periodEnd = $dateTime->format('Y-m-d');
    //Get events Api
    $api->eventsAPI();
    //Set limit to 10 events
    $api->setLimit(10);
    //Events from date
    $api->setStart($periodStart);
    //Events to date
    $api->setEnd($periodEnd);
    try {
        $events = $api->get();
    } catch (Exception $e) {
        echo 'error:'.$e->getMessage();
    }
    //Dump decoded json
    var_dump($events);