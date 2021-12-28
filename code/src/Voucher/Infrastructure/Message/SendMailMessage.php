<?php

namespace App\Voucher\Infrastructure\Message;

class SendMailMessage
{
    private $content;

    public function __construct( $content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }

}
