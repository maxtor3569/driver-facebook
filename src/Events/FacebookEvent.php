<?php

namespace GaryBot\Drivers\Facebook\Events;

use GaryBot\Drivers\DriverEventInterface;

abstract class FacebookEvent implements DriverEventInterface
{
    protected $payload;

    /**
     * @param $payload
     */
    public function __construct($payload)
    {
        $this->payload = $payload;
    }

    /**
     * Return the event name to match.
     *
     * @return string
     */
    abstract public function getName();

    /**
     * Return the event payload.
     *
     * @return mixed
     */
    public function getPayload()
    {
        return $this->payload;
    }
}
