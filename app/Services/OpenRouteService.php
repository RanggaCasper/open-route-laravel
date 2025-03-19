<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class OpenRouteService
{
    protected $client;
    protected $apiKey;
    protected $baseUrl = 'https://api.openrouteservice.org/';

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->apiKey = env('OPENROUTESERVICE_API_KEY');
    }
    
    public function getGeocode($location)
    {
        try {
            $response = $this->client->get($this->baseUrl . 'geocode/search', [
                'query' => [
                    'api_key' => $this->apiKey,
                    'text' => $location,
                ],
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            return $data;
        } catch (RequestException $e) {
            return ['error' => $e->getMessage()];
        }
    }
    
    public function getRoute($locations)
    {
        try {
            $data = [
                'coordinates' => $locations, 
                'instructions' => false, 
            ];

            $response = $this->client->post($this->baseUrl . 'v2/directions/driving-car', [
                'json' => $data,
                'headers' => [
                    'Authorization' => $this->apiKey,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
