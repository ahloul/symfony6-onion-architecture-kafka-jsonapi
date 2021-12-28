<?php

namespace App\Voucher\Application\Services;

use App\Voucher\Domain\Repositories\VoucherRepositoryInterface;

class GenerateVoucher
{
    const Voucher_code_length = 10;
    private $voucherRepository;

    public function __construct(VoucherRepositoryInterface $voucherRepository)
    {
        $this->voucherRepository = $voucherRepository;
    }



    public function generateCode(): string
    {
        $code= substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 1, self::Voucher_code_length);
        if ($this->checkIfCodeExists($code)){
            $code=$this->generateCode();
        }
        return $code;
    }

    private function checkIfCodeExists($code)
    {
        return $this->voucherRepository->findByCode($code);
    }
}
