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

            case "GET":

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

            case isset($request['btn-del-county']):

                $client->delete('counties', $request['btn-del-county']);

                PageCounties::table(self::getCounties());

                break;

            case isset($request['btn-save-county']):

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
                $countyId = self::getCountyId($request);
                PageCities::dropdown(self::getCounties(), $countyId);
                self::showCities($countyId); 
                PageCities::generateAlphabetButtons(self::getCities($countyId)); // Generáljuk a betűgombokat
                break;
            case isset($request['btn-del-city']):
                $client->delete('cities', $request['btn-del-city']);
                $countyId = self::getCountyId($request);
                PageCities::dropdown(self::getCounties(), $countyId);
                self::showCities($countyId); 
                break;

                case isset($request['btn-save-city']);
                $cityName = $request['city'];
                $countyId = self::getCountyId($request);
                $client->post('cities', ['city' => $cityName, 'id_county' => $countyId]);
                PageCities::dropdown(self::getCounties(), $countyId);
                self::showCities($countyId);
                break;  
                
            case isset($request['btn-edit-city']):
                $cityId = $request['btn-edit-city'];
                $countyId = self::getCountyId($request);
                $city = $client->get("counties/$countyId/cities/$cityId")['data'];
                PageCities::editForm($city);
                break;

                case isset($request['btn-update-city']):
                    $cityId = $request['id']; // Get the city ID from the form
                    $cityName = $request['city']; // Get the city name from the form
                    $zipCode = $request['zip_code']; // Get the zip code from the form
                    $countyId = self::getCountyId($request); // Get the county ID if needed
                    $client->put("counties/$countyId/cities/$cityId", ['city' => $cityName, 'zip_code' => $zipCode]);
                    PageCities::table(self::getCounties());
                    break;

            case isset($request['btn-cancel']): 

                PageCounties::table(self::getCounties());

                break;

            case isset($request['btn-alphabet']):

                $letter = $request['btn-alphabet']; // Lekérjük a kiválasztott betűt

                $countyId = self::getCountyId($request); 

                self::showCitiesByLetter($countyId, $letter); // Csak az adott betűvel kezdődő városokat jelenítjük meg

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
 
    private static function showCitiesByLetter($countyId, $letter)

    {

        $client = new Client();

        $response = $client->get("counties/$countyId/cities");

        $cities = $response['data'] ?? [];
 
        // Filter the cities based on the selected letter

        $filteredCities = array_filter($cities, function($city) use ($letter) {

            return strtoupper(substr($city['city'], 0, 1)) === strtoupper($letter);

        });
 
        // Display the filtered cities

        PageCities::table(array_values($filteredCities));

    }
 
    private static function getCities($countyId): array

    {

        $client = new Client();

        $response = $client->get("counties/$countyId/cities");

        return $response['data'] ?? [];

    }
 
    private static function getCountyId($request)

    {

        if(isset($request['id_county'])){

            $_SESSION['id_county'] = $request['id_county'];

            return $request['id_county'];

        }

        return $_SESSION['id_county'];

    }
 
    private static function getCityId($request)

    {

        if(isset($request['btn-edit-city'])){

            $_SESSION['btn-edit-city'] = $request['btn-edit-city'];

            return $request['btn-edit-city'];

        }

        return $_SESSION['btn-edit-city'];

    }

}
 