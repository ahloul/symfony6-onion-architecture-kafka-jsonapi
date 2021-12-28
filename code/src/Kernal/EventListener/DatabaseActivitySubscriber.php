<?php

namespace App\Kernal\EventListener;

use App\Kernal\Message\KafkaMessage;
use App\Voucher\Domain\Entities\Purchase;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Messenger\MessageBusInterface;

class DatabaseActivitySubscriber implements EventSubscriberInterface
{
    private $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }
    // this method can only return the event names; you cannot define a
    // custom method name to execute when each event triggers
    public function getSubscribedEvents(): array
    {
        return [
            Events::postPersist,
            Events::postRemove,
            Events::postUpdate,
        ];
    }

    // callback methods must be called exactly like the events they listen to;
    // they receive an argument of type LifecycleEventArgs, which gives you access
    // to both the entity object of the event and the entity manager itself
    public function postPersist(LifecycleEventArgs $args): void
    {
        $this->logActivity('persist', $args);
    }

    private function logActivity(string $action, LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if ($entity instanceof Purchase && $action = 'persist') {
            $body =
                [
                    'key'=>'purchased_created',
                    'purchased_at' => $entity->getPurchasedAt(),
                    'voucher_id' => $entity->getVoucher()->getId(),
                    'voucher_price' => $entity->getVoucher()->getPrice(),
                    'voucher_valid_to' => $entity->getVoucher()->getValidTo()->format('Y-m-d H:i:s'),
                    'voucher_valid_from' => $entity->getVoucher()->getVaildFrom()->format('Y-m-d H:i:s'),
                    'voucher_code' => $entity->getVoucher()->getCode(),
                    'user_id' => $entity->getUser()->getId(),
                    'user_email' => $entity->getUser()->getEmail(),
                    'user_tier' => $entity->getUser()->getTier(),
                ];

            $this->bus->dispatch(new KafkaMessage('purchased_created', $body));

        }

        // if this subscriber only applies to certain entity types,
        // add some code to check the entity type as early as possible
//        dd($action,1,$entity);

        // ... get the entity information and log it somehow
    }

    public function postRemove(LifecycleEventArgs $args): void
    {
        $this->logActivity('remove', $args);
    }

    public function postUpdate(LifecycleEventArgs $args): void
    {
        $this->logActivity('update', $args);
    }
}
