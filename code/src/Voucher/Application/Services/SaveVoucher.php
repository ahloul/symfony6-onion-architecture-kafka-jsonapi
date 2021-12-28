<?php

namespace App\Voucher\Application\Services;

use App\Voucher\Domain\Repositories\VoucherRepositoryInterface;

class SaveVoucher
{
    private $voucherRepository;

    public function __construct(VoucherRepositoryInterface $voucherRepository)
    {
        $this->voucherRepository = $voucherRepository;
    }

    public function save(array $data)
    {
        //it's not commanded to use dependency inject for application serivcex
        $generateCodeService = new GenerateVoucher($this->voucherRepository);
        $data['code'] = $generateCodeService->generateCode();
        return $this->voucherRepository->save($data);
    }
}
