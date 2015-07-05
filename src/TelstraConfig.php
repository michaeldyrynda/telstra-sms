<?php

namespace Iatstuti\TelstraSms;

/**
 * Telstra configuration object
 *
 * @package    Iatstuti\TelstraSms
 * @copyright  2015 IATSTUTI
 * @author     Michael Dyrynda <michael@iatstuti.net>
 */
class TelstraConfig
{
    /**
     * Store the API key.
     *
     * @var string
     */
    public $apiKey;

    /**
     * Store the API secret.
     *
     * @var string
     */
    public $apiSecret;


    /**
     * Class constructor.
     *
     * @param string $apiKey    The Telstra API key
     * @param string $apiSecret The Telstra API secret
     */
    public function __construct($apiKey, $apiSecret)
    {
        $this->apiKey    = $apiKey;
        $this->apiSecret = $apiSecret;
    }
}
