<?php

namespace App\Voucher\UI\Api\Transformer;

use App\Voucher\Domain\Entities\Voucher;
use League\Fractal\TransformerAbstract;


class VoucherTransformer extends TransformerAbstract
{
    public function transform(Voucher $voucher)
    {
        return [
            'id' => (int)$voucher->getId(),
            'code' => $voucher->getCode(),
            'description' => (string)$voucher->getDescription(),
            'price' => (float)$voucher->getPrice(),
            'quantityInStock' => (int)$voucher->getQuantityInStock(),
            'vaildFrom' => $voucher->getVaildFrom()->format('Y-m-d H:i:s'),
            'validTo' => $voucher->getValidTo()->format('Y-m-d H:i:s'),

        ];
    }
}
