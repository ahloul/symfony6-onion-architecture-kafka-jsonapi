<?php
namespace App\Voucher\Infrastructure\MessageHandler;

use App\Kernal\Message\KafkaMessage;
use App\Voucher\Infrastructure\Message\SendMailMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class SendMailMessageHandler implements MessageHandlerInterface
{
    public function __invoke(SendMailMessage $message)
    {

        }
}
