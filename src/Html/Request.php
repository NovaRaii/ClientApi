<?php
namespace App\Html;

use App\RestApiClient\Client;

class Request
{
    static function handle()
    {
        switch ($_SERVER["REQUEST_METHOD"]){
            case "POST":
                self::postRequest();
                break;
            case "GET":
                default:
                   // self::getRequest();
                    break;
        }
    }

    private static function postRequest()
    {
        $request = $_REQUEST;
        switch ($request){
            case isset($request['btn-home']):
                break;
            case isset($request['btn-counties']):
                PageCounties::table(entities: self::getCounties());
                break;
        }
    }

    private static function getRequest()
    {
        $request = $_REQUEST;
        switch ($request) {
            case isset($request['btn-counties']) :
                PageCounties::table(self::getCounties());
                break;
        }
    }
    
    private static function getCounties()
    {
        $client = new Client();
        $response = $client->get('counties');

        return $response['data'];
    }
}
?>