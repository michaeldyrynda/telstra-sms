<?php

namespace Iatstuti\TelstraSms;

use GuzzleHttp\Exception\ClientException;
use Iatstuti\TelstraSms\Api\Client;
use Iatstuti\TelstraSms\Contracts\Sms\Send as SmsSend;
use Iatstuti\TelstraSms\Exceptions\TelstraSmsException;
use Iatstuti\TelstraSms\TelstraConfig;

/**
 * Telstra implementation of the SMS sending interface.
 *
 * @package    Iatstuti\TelstraSms
 * @copyright  2015 IATSTUTI
 * @author     Michael Dyrynda <michael@iatstuti.net>
 */
class TelstraSmsSend extends TelstraSms implements SmsSend
{
    /**
     * The maximum character count for a message.
     */
    const MAXIMUM_MESSAGE_LENGTH = 160;

    /**
     * Store the message to be sent.
     *
     * @var string
     */
    private $message;

    /**
     * Store the recipient number.
     *
     * @var string
     */
    private $number;


    /**
     * Set the message text.
     *
     * @throws TelstraSmsException If message length exceeds maximum allowed.
     *
     * @param  string     $message The message text
     * @return TelstraSms
     */
    public function message($message)
    {
        if (strlen($message) > self::MAXIMUM_MESSAGE_LENGTH) {
            throw new TelstraSmsException(sprintf(
                'Message length must not exceed %d characters',
                self::MAXIMUM_MESSAGE_LENGTH
            ));
        }

        $this->message = $message;

        return $this;
    }


    /**
     * Set the recipient number(s).
     *
     * @param  string $number Recipient phone numbers.
     * @return TelstraSms
     */
    public function to($number)
    {
        $this->number = $number;

        return $this;
    }


    /**
     * Send the message.
     *
     * @throws TelstraSmsException If the message is empty
     * @throws TelstraSmsException If no recipient numbers have been specified
     *
     * @return string Message identifier
     */
    public function send()
    {
        if (trim($this->message) == '') {
            throw new TelstraSmsException('You cannot send an empty message.');
        }

        if (trim($this->number) == '') {
            throw new TelstraSmsException('You must specify a recipient number.');
        }

        try {
            $response = $this->client->post('sms/messages', [
                'headers' => $this->client->getAuthorisationHeader(),
                'json' => [
                    'to'   => $this->number,
                    'body' => $this->message,
                ],
            ]);

            $response_json = json_decode($response->getBody()->getContents());

            return $response_json->messageId;
        } catch (\Exception $e) {
            throw new TelstraSmsException('Could not send message - ' . $e->getMessage());
        }
    }
}
