<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\RequestException;

/**
 * Class WMATAApiController
 * @package App\Http\Controllers
 */
class WMATAApiController extends Controller
{
    /**
     * HTTP Client
     * @var Client
     */
    private $client;

    /**
     * This would be in a config file
     *
     * @var string
     */
    private $apiKey = 'ae5407ec54774e33ac1ccf0241faaf2c';

    /**
     * WMATAApiController constructor
     */
    public function __construct()
    {
        /**
         * In a full app, I would move the API calls into a service class whose
         * primary concern would be Access the api, that client would be preconfigured and injected in this class.
         * Right now it is impossible to easily switch out implementations for testing
         */
        $this->client = new Client([
            'base_uri' => 'https://api.wmata.com',
            'headers' => [
                'api_key' => $this->apiKey
            ]
        ]);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function getStationList()
    {
        try {
            $response = $this->client->get('/Rail.svc/json/jStations');

            /**
             * in a full app, I wouldn't just pass the request on to the frontend,
             * I would transform it based on what the agreed upon contract with the frontend
             * was
             */
            return response()->make(
                $response->getBody()->getContents(),
                $response->getStatusCode()
            );

        } catch(RequestException $requestException) {
            /**
             * In a full app, all exceptions would be logged in some sort of logging store
             * and monitoring/alerts would be set up based on the type, if it were something
             * that needed to be looked at
             */
            return response()->make(
                json_encode(['error' => $requestException->getMessage()]),
                400
            );
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getNextTrains(Request $request)
    {
        /**
         * In a full app this would be
         * validated by the request and a 422 returned before the
         * request was ever made
         */
        $stationCode = $request->query('stationCode');

        try {
            $response = $this->client->get('/StationPrediction.svc/json/GetPrediction/'.$stationCode);

            /**
             * in a full app, I wouldn't just pass the request on to the frontend,
             * I would transform it  based on what the agreed upon contract with the frontend
             * was
             */
            return response()->make(
                $response->getBody()->getContents(),
                $response->getStatusCode()
            );

        } catch(RequestException $requestException) {
            /**
             * In a full app, all exceptions would be logged in some sort of logging store
             * and monitoring/alerts would be set up based on the type, if it were something
             * that needed to be looked at
             */
            return response()->make(
                json_encode(['error' => $requestException->getMessage()]),
                400
            );
        }
    }
}
