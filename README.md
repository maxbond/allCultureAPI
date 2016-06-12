# allCultureAPI
PHP API wrapper for russian culture events database all.culture.ru 

## Usage:
install via composer: composer require maxbond/allcultureapi
    
    $api = new Maxbond\AllCultureAPI\Api;
    try {
            $dateTime = new DateTime();
            $periodStart = $dateTime->format('Y-m-d');
            $dateTime->add(new DateInterval('P1D'));
            $periodEnd = $dateTime->format('Y-m-d');
            $api->eventsAPI();
            $api->setLimit(10);
            $api->setStart($periodStart);
            $api->setEnd($periodEnd);
            $events = $api->get();
        } catch (Exception $e) {
            echo 'error:'.$e->getMessage();
        }
        var_dump($events);