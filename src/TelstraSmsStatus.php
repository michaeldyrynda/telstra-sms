<?php

namespace Iatstuti\TelstraSms;

use Iatstuti\TelstraSms\Api\Client;
use Iatstuti\TelstraSms\Contracts\Sms\Status as SmsStatus;
use Iatstuti\TelstraSms\Exceptions\TelstraSmsException;

/**
 * Telstra implementation of the SMS status interface.
 *
 * @package    Iatstuti\TelstraSms
 * @copyright  2015 IATSTUTI
 * @author     Michael Dyrynda <michael@iatstuti.net>
 */
class TelstraSmsStatus extends TelstraSms implements SmsStatus
{
    /**#@+
     * Response code
     */
    /** Pending status */
    const RESPONSE_STATUS_PEND    = 'PEND';

    /** Sent status */
    const RESPONSE_STATUS_SENT    = 'SENT';

    /** Delivered status */
    const RESPONSE_STATUS_DELIVRD = 'DELIVRD';

    /** Read status */
    const RESPONSE_STATUS_READ    = 'READ';
    /**#@-*/

    /**
     * Store the recipient number after a fetch.
     *
     * @var string
     */
    public $recipient;

    /**
     * Store the sent timestamp after a fetch.
     *
     * @var string
     */
    public $sent;

    /**
     * Store the received timestamp after a fetch.
     *
     * @var string
     */
    public $received;

    /**
     * Store the status code after a fetch.
     *
     * @var string
     */
    public $status;


    /**
     * Fetch the status of the given message identifier.
     *
     * @param  string $messageId Message identifier to fetch status of
     * @return boolean
     */
    public function fetch($messageId)
    {
        $response = $this->client->get('sms/messages/' . $messageId, [ 'headers' => $this->client->getAuthorisationHeader(), ]);
        $response_json = json_decode($response->getBody()->getContents());

        if ($response->getStatusCode() == 200) {
            $this->recipient = $response_json->to;
            $this->sent      = new \DateTime($response_json->sentTimestamp);
            $this->received  = new \DateTime($response_json->receivedTimestamp);
            $this->status    = $response_json->status;

            return true;
        }

        return false;
    }


    /**
     * Fetch the status code description.
     *
     * @throws TelstraSmsException If the friendly description can't be found for the returned status
     *
     * @return string
     */
    public function getDescription()
    {
        $statuses = [
            self::RESPONSE_STATUS_PEND    => "The message is pending and has not yet been sent to the intended recipient",
            self::RESPONSE_STATUS_SENT    => "The message has been sent to the intended recipient, but has not been delivered yet",
            self::RESPONSE_STATUS_DELIVRD => "The message has been delivered to the intended recipient",
            self::RESPONSE_STATUS_READ    => "The message has been read by the intended recipient and the recipient's response has been received",
        ];

        if (array_key_exists($this->status, $statuses)) {
            return $statuses[$this->status];
        }

        throw new TelstraSmsException('You must fetch the message status before getting the description.');
    }
}
