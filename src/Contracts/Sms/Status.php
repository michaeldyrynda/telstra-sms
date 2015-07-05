<?php

namespace Iatstuti\TelstraSms\Contracts\Sms;

/**
 * Declare an interface for fetching the status of a sent message.
 *
 * @package    Iatstuti\TelstraSms
 * @subpackage Contracts\Sms
 * @copyright  2015 IATSTUTI
 * @author     Michael Dyrynda <michael@iatstuti.net>
 */
interface Status
{
    /**
     * Fetch the status of the given message identifier.
     *
     * @param  string $messageId Message identifier
     * @return string
     */
    public function fetch($messageId);

    /**
     * Fetch the status code description.
     *
     * @return string
     */
    public function getDescription();
}
