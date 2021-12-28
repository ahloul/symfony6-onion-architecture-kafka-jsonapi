<?php

namespace App\Voucher\UI\Api\Admin\Controllers;

use App\Kernal\Traits\JsonApi;
use App\Voucher\Application\Services\SaveVoucher;
use App\Voucher\Domain\Repositories\VoucherRepositoryInterface;
use App\Voucher\UI\Api\Transformer\VoucherTransformer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class VoucherController extends AbstractController
{
    use JsonApi;

    private $voucherRepository;

    public function __construct(VoucherRepositoryInterface $voucherRepository)
    {
        $this->voucherRepository = $voucherRepository;
    }



    #[Route('/', name: 'admin_voucher_create', methods: ['post'])]
    public function create(Request $request): Response
    {
        $data = $this->getAttributesData($request);

        //it's not commanded to use dependency inject for application service
        $saveVoucherService = new SaveVoucher($this->voucherRepository);
        $voucher = $saveVoucherService->save($data);

        return $this->json($this->srializeToJsonApi($voucher, new VoucherTransformer(), 'voucher'));
    }

}
