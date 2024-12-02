<?php

namespace App\Html;

use App\RestApiClient\Client;

class Request {

    static function handle()
    {
        switch ($_SERVER["REQUEST_METHOD"]){
            case "POST":
                self::postRequest();
                break;
            case "GET";
            default:
                //self::getRequest();
                break;
        }
    }

    private static function postRequest()
    {
        $request = $_REQUEST;
        $client = new Client();
        switch ($request){
            case isset($request['btn-home']):
                break;
            case isset($request['btn-counties']):
                PageCounties::table(self::getCounties());
                break;
            //counties
            case isset($request['btn-del-county']);
                $client->delete('counties', $request['btn-del-county']);
                PageCounties::table(self::getCounties());
                break;
            case isset($request['btn-save-county']);
                $countyName = $request['name'];
                $client->post('counties', ['name' => $countyName]);
                PageCounties::table(self::getCounties());
                break;
            case isset($request['btn-edit-county']):
                $countyId = $request['btn-edit-county'];
                $county = $client->get("counties/$countyId")['data'];
                PageCounties::editForm($county);
                break;
            case isset($request['btn-update-county']):
                $countyId = $request['id'];
                $countyName = $request['name'];
                $client->put("counties/$countyId", ['name' => $countyName]);
                PageCounties::table(self::getCounties());
                break;
            case isset($request['btn-cancel']):
                PageCounties::table(self::getCounties());
                break;
            case isset($request['btn-cities']):
                PageCities::dropdown(self::getCounties());
                $countyId = $request['id_county'];
                self::showCities($countyId); 
                break;
            //cities
            case isset($request['btn-del-city']);
                $client->delete('cities', $request['btn-del-city']);
                PageCities::dropdown(self::getCounties());
                $countyId = $request['id_county'];
                self::showCities($countyId);
                PageCities::table(self::getCounties());
                break;
            case isset($request['btn-save-city']);
                $cityName = $request['city'];
                $client->post('cities', ['city' => $cityName]);
                PageCities::table(self::getCounties());
                break;
            case isset($request['btn-edit-city']):
                $cityId = $request['btn-edit-city'];
                $city = $client->get("cities/$cityId")['data'];
                PageCities::editForm($city);
                break;
            case isset($request['btn-update-city']):
                $cityId = $request['id'];
                $cityName = $request['city'];
                $client->put("cities/$cityId", ['city' => $cityName]);
                PageCities::table(self::getCounties());
                break;
            case isset($request['btn-cancel']):
                PageCounties::table(self::getCounties());
                break;
            case isset($request['btn-cities']):
                PageCities::dropdown(self::getCounties());
                $countyId = $request['id_county'];
                self::showCities($countyId); 
                break; 
        }
    }


    private static function getCounties() : array
    {
        $client = new Client();
        $response = $client->get('counties');

        return $response['data'];
    }

    private static function showCities($countyId)
    {
        $client = new Client();
        $response = $client->get("counties/$countyId/cities");
        $cities = $response['data'] ?? [];

        PageCities::table($cities);
    }
}