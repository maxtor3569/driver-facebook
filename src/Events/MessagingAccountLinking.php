<?php

namespace GaryBot\Drivers\Facebook\Events;

use GaryBot\Drivers\Facebook\FacebookDriver;

class MessagingAccountLinking extends FacebookDriver
{
    /**
     * Return the event name to match.
     *
     * @return string
     */
    public function getName()
    {
        return 'messaging_account_linking';
    }
}
