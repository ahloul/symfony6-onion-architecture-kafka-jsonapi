<?php

// src/EventListener/UserChangedNotifier.php
namespace App\Voucher\Infrastructure\EventListeners;

use App\Kernal\Message\KafkaMessage;
use App\Voucher\Domain\Entities\Redeem;
use App\Voucher\Domain\Repositories\VoucherRepositoryInterface;
use App\Voucher\Infrastructure\Message\SendMailMessage;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Messenger\MessageBusInterface;

class RredeemChangedNotifier
{
    private $voucherRepository;
    private $bus;

    public function __construct(VoucherRepositoryInterface $voucherRepository,MessageBusInterface $bus)
    {
        $this->voucherRepository = $voucherRepository;
        $this->bus = $bus;
    }
    // the entity listener methods receive two arguments:
    // the entity instance and the lifecycle event
    public function postPersist(Redeem $redeem, LifecycleEventArgs $event): void
    {
        $this->bus->dispatch(new SendMailMessage($redeem));

        $this->voucherRepository->setPurchasedVoucherAsRedeemed($redeem);
    }
}
