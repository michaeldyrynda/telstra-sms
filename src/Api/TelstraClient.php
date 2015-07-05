<?php

namespace Iatstuti\TelstraSms\Api;

use GuzzleHttp\Client as GuzzleClient;
use Iatstuti\TelstraSms\TelstraConfig;

/**
 * Telstra API client
 *
 * @package    Iatstuti\TelstraSms
 * @subpackage Api
 * @copyright  2015 IATSTUTI
 * @author     Michael Dyrynda <michael@iatstuti.net>
 */
final class TelstraClient
{
    /**
     * Store the configuration object.
     *
     * @var TelstraConfig
     */
    private $config;

    /**
     * Store the Guzzle client instance.
     *
     * @var GuzzleHttp\Client
     */
    private $client;

    /**
     * Store the access token.
     *
     * @var string
     */
    private $token;

    public function __construct(TelstraConfig $config)
    {
        $this->config = $config;
        $this->client = new GuzzleClient([
            'base_uri' => 'https://api.telstra.com/v1/sms',
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ]);

        $this->authenticate();
    }


    /**
     * Authenticate the request.
     *
     * @return boolean
     */
    private function authenticate()
    {
        try {
            $response = $this->client->get('oauth/token', [
                'query' => [
                    'client_id'     => $this->config->apiKey,
                    'client_secret' => $this->config->apiSecret,
                    'grant_type'    => 'client_credentials',
                    'scope'         => 'SMS',
                ],
            ]);

            if ($response->getStatusCode() == 200) {
                $response_json = json_decode($response->getBody()->getContents());
                $this->token   = $response_json->access_token;

                return true;
            }

            throw new TelstraSmsException('Could not get an access token.');
        } catch (\Exception $e) {
            throw new TelstraSmsException($e->getMessage() ?: 'Could not authenticate with the Telstra API.');
        }
    }


    /**
     * Get the client token.
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }


    /**
     * Get the authorisation header.
     *
     * @return array
     */
    public function getAuthorisationHeader()
    {
        return [ 'Authorization' => 'Bearer ' . $this->token, ];
    }


    /**
     * Any undeclared methods should be passed directly to the Guzzle client.
     *
     * @param  string $method The method being called
     * @param  mixed  $args   The arguments to pass to the method
     * @return mixed
     */
    public function __call($method, $args)
    {
        return call_user_func_array([ $this->client, $method, ], $args);
    }
}
