<?php

namespace Iatstuti\TelstraSms\Contracts\Sms;

/**
 * Declare an interface for sending SMS messages.
 *
 * @package    Iatstuti\TelstraSms
 * @subpackage Contracts\Sms
 * @copyright  2015 IATSTUTI
 * @author     Michael Dyrynda <michael@iatstuti.net>
 */
interface Send
{
    /**
     * Set the message string.
     * @param  string $string The message to send
     */
    public function message($string);

    /**
     * Set the recipient phone number.
     *
     * @param  string $number One or more numbers the message should be sent to.
     */
    public function to($number);

    /**
     * Send the message
     *
     * @return string Message identifier.
     */
    public function send();
}
