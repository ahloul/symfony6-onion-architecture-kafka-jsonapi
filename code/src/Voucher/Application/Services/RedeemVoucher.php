<?php

namespace App\Voucher\Application\Services;

use App\Voucher\Domain\Repositories\VoucherRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Exception\ValidatorException;

class RedeemVoucher
{
    private $voucherRepository;

    public function __construct(VoucherRepositoryInterface $voucherRepository)
    {
        $this->voucherRepository = $voucherRepository;
    }


    public function redeem($user, string $code)
    {
        $voucher = $this->voucherRepository->findByCode($code);
        if (!$voucher) {
            throw new NotFoundHttpException('Voucher not found');
        }
        //check if user already purchase voucher before
        $count = $this->voucherRepository->checkIfAlreadyPurchased($user, $voucher->getId());
        if ($count == 0) {
            throw new ValidatorException('You don\'t purchased that voucher.');
        }

        //check if user already redeemed voucher before
        $count = $this->voucherRepository->checkIfVoucherAlreadyRedeemed($user, $voucher->getId());

        if ($count != 0) {
            throw new ValidatorException('Voucher already redeemed');

        }

        //check if user already  voucher still valid
        $validTo = $this->voucherRepository->getVoucherVaildTo($voucher->getId());
        if (new \DateTime($validTo) < new \DateTime()) {
            throw new ValidatorException('Voucher not valid.');

        }

        $this->voucherRepository->redeem($user, $voucher);
    }


}
