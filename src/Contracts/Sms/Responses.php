<?php

namespace Iatstuti\TelstraSms\Contracts\Sms;

/**
 * Declare an interface for retrieving SMS responses.
 *
 * @package    Iatstusi\TelstraSms
 * @subpackage Contracts\Sms
 * @copyright  2015 IATSTUTI
 * @author     Michael Dyrynda <michael@iatstuti.net>
 */
interface Responses
{
    /**
     * Fetch the response(s) for a given message identifier
     */
    public function fetch($messageId);

    /**
     * Get the responses.
     */
    public function getAll();

    /**
     * Return a count of the number of responses.
     */
    public function count();
}
