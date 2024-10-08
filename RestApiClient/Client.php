<?php

namespace App\RestApiClient;

use App\Interfaces\ClientInterface;
use Exception;

class Client implements ClientInterface {

    const API_URL = 'http://localhost:8000';
    /**
     * The whole url including host, api uri and jql query.
     * @var string
     */
    protected $url;

    function __construct($url = self::API_URL) 
    {
        $this->url = $url;
    }

    public function getUrl() {
        return $this->url;
    }

    function get($route, array $query = []) 
    {
        $url = $this->getUrl() . $route;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl,
            CURLOPT_HTTPHEADER,
            array('Content-Type: application/json'));
        $response = curl_exec($curl);
        //  $result = self::getResult($response, $curl, $url)
        if (!response) {
            trigger_error(curl_error($curl));
        }
        curl_close($curl);

        return json_decode($response, TRUE);
    }
    
}