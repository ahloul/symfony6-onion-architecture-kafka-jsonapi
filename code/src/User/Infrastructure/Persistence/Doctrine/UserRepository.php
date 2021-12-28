<?php

namespace App\Voucher\Infrastructure\Persistence\Doctrine;

use App\User\Domain\Entities\User;
use App\Voucher\Domain\Entities\Voucher;
use App\Voucher\Domain\Repositories\VoucherRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class UserRepository
{
    /** @var EntityRepository */
    private $voucherRepository;

    /** @var EntityManagerInterface */
    private $entityManager;

    //@Doctrine\ORM\EntityManagerInterface
    public function __construct(EntityManagerInterface $entityManager)
    {

        $this->entityManager = $entityManager;
        $this->voucherRepository = $entityManager->getRepository(Voucher::class);
    }

    public function find(string $id): Voucher
    {
       return $this->voucherRepository->find($id);
    }

    public function save(User $voucher): void
    {
        $this->entityManager->persist($voucher);
        $this->entityManager->flush();
    }
    public function findAll()
    {
        return $this->voucherRepository->findAll();
    }


}

