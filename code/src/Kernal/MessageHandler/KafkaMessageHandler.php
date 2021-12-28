<?php
namespace App\Kernal\MessageHandler;

use App\Kernal\Message\KafkaMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class KafkaMessageHandler implements MessageHandlerInterface
{
    public function __invoke(KafkaMessage $message)
    {

        }
}
