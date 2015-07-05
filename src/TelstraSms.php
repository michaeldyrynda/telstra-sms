<?php

namespace Iatstuti\TelstraSms;

use Iatstuti\TelstraSms\Api\TelstraClient;

/**
 * Abstract Telstra SMS class.
 *
 * Should implement only functionality common across descendents.
 *
 * @package    Iatstuti\TelstraSms
 * @copyright  2015 IATSTUTI
 * @author     Michael Dyrynda <michael@iatstuti.net>
 */
abstract class TelstraSms
{
    /**
     * Store the Telstra API client.
     *
     * @var TelstraClient
     */
    protected $client;


    /**
     * Class constructor.
     *
     * @param TelstraClient $client Telstra API client
     */
    public function __construct(TelstraClient $client)
    {
        $this->client = $client;
    }
}
