<?php

namespace GaryBot\Drivers\Facebook\Events;

class MessagingOptins extends FacebookEvent
{
    /**
     * Return the event name to match.
     *
     * @return string
     */
    public function getName()
    {
        return 'messaging_optins';
    }
}
