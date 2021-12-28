<?php

namespace App\Kernal\Messenger;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use function dd;

final class KafkaMessageSerializer implements SerializerInterface
{
    public function decode(array $encodedEnvelope): Envelope
    {
//        $record = json_decode($encodedEnvelope['body'], true);
//
//        return new Envelope();
    }

    public function encode(Envelope $envelope): array
    {

       $message= $envelope->getMessage();

        return [
            'key' => $message->getAction(),
            'headers' => ['Content-Type' => 'application/vnd.kafka.binary.v2+json'],
            'body' => json_encode($message->getBody()),
        ];
    }

}
