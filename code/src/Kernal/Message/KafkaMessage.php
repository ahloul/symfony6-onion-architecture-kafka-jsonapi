<?php

namespace App\Kernal\Message;

class KafkaMessage
{
    private $content;

    public function __construct(string $action, $body)
    {
        $this->action = $action;
        $this->body = $body;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getAction()
    {
        return $this->action;
    }
}
