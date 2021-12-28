<?php

namespace App\Voucher\Domain\Repositories;

use App\User\Domain\Entities\User;
use App\Voucher\Domain\Entities\Voucher;

interface VoucherRepositoryInterface
{
    //not recommend to use models(entities) in high level
    //should not use voucher or user

    public function find(string $id): ?Voucher;
    public  function findByCode(string $code): ?Voucher;
    public function save(array $data): Voucher;

    public function findAll();

    public function purchase($user, $id);

    public function checkIfAlreadyPurchased(User $user, $voucherId);

    public function checkIfVoucherAlreadyRedeemed(User $user, $voucherId);

    public function getVoucherVaildTo(string $voucherId);

    public function redeem(User $user, Voucher $voucher);



}
