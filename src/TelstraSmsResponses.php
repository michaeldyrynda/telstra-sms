<?php

namespace Iatstuti\TelstraSms;

use Countable;
use Iatstuti\TelstraSms\Contracts\Sms\Responses;

/**
 * Telstra implementation of the SMS responses interface.
 *
 * @package    Iatstuti\TelstraSms
 * @copyright  2015 IATSTUTI
 * @author     Michael Dyrynda <michael@iatstuti.net>
 */
class TelstraSmsResponses extends TelstraSms implements Responses, Countable
{
    /**
     * Store the responses after a fetch.
     *
     * @var array
     */
    protected $responses = [];


    /**
     * Fetch the response(s) for a given message identifier.
     *
     * @param  string $messageId Message identifier
     * @return boolean
     */
    public function fetch($messageId)
    {
        $response = $this->client->get(sprintf('sms/messages/%s/response', $messageId), [
            'headers' => $this->client->getAuthorisationHeader(),
        ]);

        if ($response->getStatusCode() == 200) {
            $this->responses = json_decode($response->getBody()->getContents());

            // Convert the timestamp to a DateTime object
            foreach ($this->responses as $key => $value) {
                $this->responses[$key]->acknowledgedTimestamp = new \DateTime($value->acknowledgedTimestamp);
            }

            return true;
        }

        return false;
    }


    /**
     * Get the responses.
     *
     * @return array
     */
    public function getAll()
    {
        return $this->responses;
    }


    /**
     * Return a count of the number of responses.
     *
     * @return integer
     */
    public function count()
    {
        return count($this->responses);
    }
}
