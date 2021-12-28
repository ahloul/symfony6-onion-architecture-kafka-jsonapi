<?php
namespace App\Infrastructure\Messenger;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

final class MySerializer implements SerializerInterface
{
    public function decode(array $encodedEnvelope): Envelope
    {
        $record = json_decode($encodedEnvelope['body'], true);

        return new Envelope(

        );
    }

    public function encode(Envelope $envelope): array
    {

        return [
            'key' => "dddd",
            'headers' => [],
            'body' => json_encode([
                'id' => 1,
                'name' =>'222',
                'description' => '222',
            ]),
        ];
    }

}
