<?php

namespace App\Voucher\Infrastructure\Persistence\Doctrine;

use App\User\Domain\Entities\User;
use App\Voucher\Domain\Entities\Purchase;
use App\Voucher\Domain\Entities\Redeem;
use App\Voucher\Domain\Entities\Voucher;
use App\Voucher\Domain\Repositories\VoucherRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class VoucherRepository implements VoucherRepositoryInterface
{
    /** @var EntityRepository */
    private $voucherRepository;

    /** @var EntityManagerInterface */
    private $entityManager;

    //@Doctrine\ORM\EntityManagerInterface
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->model = new Voucher();
        $this->entityManager = $entityManager;
        $this->voucherRepository = $entityManager->getRepository(Voucher::class);;
    }

    public function save(array $data): Voucher
    {
        $voucher = $this->getModel();
        $voucher->setCode($data['code']);
        $voucher->setDescription($data['description']);
        $voucher->setPrice($data['price']);
        $voucher->setQuantityInStock($data['quantityInStock']);
        $voucher->setVaildFrom(new \DateTime('@' . strtotime($data['vaildFrom'])));
        $voucher->setValidTo(new \DateTime('@' . strtotime($data['validTo'])));
        $this->entityManager->persist($voucher);
        $this->entityManager->flush();
        return $this->find($voucher->getId());
    }


    private function getModel()
    {
        return new Voucher();
    }


    public function find(string $id): ?Voucher
    {
        return $this->voucherRepository->find($id);
    }

    public function purchase($user, $id)
    {
        $purchase = new Purchase();
        $purchase->setUser($user);

        $voucher = $this->find($id);
        $v = $voucher->getVoucherPurchase()->map(function (Purchase $obj) {
            return $obj->getUser()->getId()->getVoucher()->getId();
        })->getValues();

        $purchase->setVoucher($voucher);
        $purchase->setPurchasedAt(new \DateTime());
        $purchase->setRedeemed(0);

        $voucher->addVoucherPurchase($purchase);
        $this->entityManager->persist($purchase);

        $this->entityManager->flush();
    }

    public function checkIfAlreadyPurchased($user, $voucherId)
    {


        $query = $this->entityManager->createQuery(
            'SELECT count(p.user)
            FROM App\Voucher\Domain\Entities\Purchase p
            WHERE p.user = :user_id
            and p.voucher = :voucher_id'
        )->setParameter('user_id', $user)
            ->setParameter('voucher_id', $voucherId);

        // returns an array of Product objects
        return $query->getSingleScalarResult();
    }

    public function checkIfVoucherAlreadyRedeemed($user, $voucherId)
    {
        $query = $this->entityManager->createQuery(
            'SELECT count(p.user)
            FROM App\Voucher\Domain\Entities\Redeem p
            WHERE p.user = :user_id
            and p.voucher = :voucher_id'
        )->setParameter('user_id', $user)
            ->setParameter('voucher_id', $voucherId);

        // returns an array of Product objects
        return $query->getSingleScalarResult();
    }

    public function getVoucherVaildTo($voucherId)
    {
        $query = $this->entityManager->createQuery(
            'SELECT v.validTo
            FROM App\Voucher\Domain\Entities\Voucher v
            where v.id = :voucher_id'
        )->setParameter('voucher_id', $voucherId);
        return $query->getSingleScalarResult();

    }

    public function redeem(User $user, Voucher $voucher)
    {
        $redeem = new Redeem();
        $redeem->setUser($user);


        $redeem->setVoucher($voucher);
        $redeem->setReedemedAt(new \DateTime());

        $voucher->addVoucherRedeem($redeem);
        $this->entityManager->persist($redeem);

        $this->entityManager->flush();
    }

    public function findAll()
    {
        return $this->voucherRepository->findAll();
    }

    /**
     * @param string $code
     * @return Voucher|null
     */

    public function findByCode(string $code): ?Voucher
    {
        return $this->voucherRepository->findOneBy(['code' => $code]);
    }

    public function setPurchasedVoucherAsRedeemed(Redeem $redeem)
    {
     $query= $this->entityManager->createQuery(
            'update 
             App\Voucher\Domain\Entities\Purchase p
             set p.redeemed =true
            WHERE p.user = :user_id
            and p.voucher = :voucher_id'
        )->setParameter('user_id', $redeem->getUser()->getId())
            ->setParameter('voucher_id', $redeem->getVoucher()->getId());
       $query->execute();
    }

}

