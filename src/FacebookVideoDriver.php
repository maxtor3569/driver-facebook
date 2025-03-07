<?php

namespace BotMan\Drivers\Facebook;


use GaryBot\Collection\Collection;
use GaryBot\Messages\Attachments\Video;
use GaryBot\Messages\Incoming\IncomingMessage;

class FacebookVideoDriver extends FacebookDriver
{
    const DRIVER_NAME = 'FacebookVideo';

    /**
     * Determine if the request is for this driver.
     *
     * @return bool
     */
    public function matchesRequest()
    {
        $validSignature = ! $this->config->has('facebook_app_secret') || $this->validateSignature();
        $messages = Collection::make($this->event->get('messaging'))->filter(function ($msg) {
            if (isset($msg['message']) && isset($msg['message']['attachments']) && isset($msg['message']['attachments'])) {
                return Collection::make($msg['message']['attachments'])->filter(function ($attachment) {
                    return (isset($attachment['type'])) && $attachment['type'] === 'video';
                })->isEmpty() === false;
            }

            return false;
        });

        return ! $messages->isEmpty() && $validSignature;
    }

    /**
     * Retrieve the chat message.
     *
     * @return array
     */
    public function getMessages()
    {
        if (empty($this->messages)) {
            $this->loadMessages();
        }

        return $this->messages;
    }

    /**
     * Load Facebook messages.
     */
    protected function loadMessages()
    {
        $messages = Collection::make($this->event->get('messaging'))->filter(function ($msg) {
            return isset($msg['message']) && isset($msg['message']['attachments']) && isset($msg['message']['attachments']);
        })->transform(function ($msg) {
            $message = new IncomingMessage(Video::PATTERN, $msg['sender']['id'], $msg['recipient']['id'], $msg);
            $message->setVideos($this->getVideoUrls($msg));

            return $message;
        })->toArray();

        if (count($messages) === 0) {
            $messages = [new IncomingMessage('', '', '')];
        }

        $this->messages = $messages;
    }

    /**
     * Retrieve video urls from an incoming message.
     *
     * @param array $message
     * @return array A download for the image file.
     */
    public function getVideoUrls(array $message)
    {
        return Collection::make($message['message']['attachments'])->where('type',
            'video')->pluck('payload')->map(function ($item) {
                return new Video($item['url'], $item);
            })->toArray();
    }

    /**
     * @return bool
     */
    public function isConfigured()
    {
        return false;
    }

    /**
     * @return bool
     */
    public function hasMatchingEvent()
    {
        return false;
    }
}
