<?php
namespace App\Helpers;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class GuzzleHttp {

    public function get($url) {
        $client = new Client();
        $response  = $client->request('GET', $url);

        return $response->getBody();
    }
}