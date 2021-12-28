<?php

namespace App\Voucher\UI\Api\Client\Controllers;

use App\Kernal\Traits\JsonApi;
use App\Voucher\Application\Services\RedeemVoucher;
use App\Voucher\Application\Services\SaveVoucher;
use App\Voucher\Domain\Repositories\VoucherRepositoryInterface;
use App\Voucher\UI\Api\Transformer\VoucherTransformer;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Exception\ValidatorException;

class VoucherController extends AbstractController
{
    use JsonApi;

    private $voucherRepository;
    private $tokenStorageInterface;
    private $user;

    public function __construct(VoucherRepositoryInterface $voucherRepository, TokenStorageInterface $tokenStorageInterface)
    {
        $this->voucherRepository = $voucherRepository;
        $this->user = $tokenStorageInterface->getToken()->getUser();


    }


    #[Route('/redeem', name: 'client_voucher_redeem', methods: ['post'])]
    public function redeem(Request $request): Response
    {
        //deserialize request json
        $data = $this->getAttributesData($request);
        if (!isset($data['code'])) {
            throw new ValidatorException('Code not found.');
        }
        $redeemService = new RedeemVoucher($this->voucherRepository);
        $redeemService->redeem($this->user,$data['code']);

        return $this->json(['meta' => ['message' => 'redeemed successfully']]);

    }

    #[Route('/purchase/{id}', name: 'client_voucher_purchase', methods: ['post'])]
    public function purchase(int $id): Response
    {

        //check if user already purchase voucher before
        $count = $this->voucherRepository->checkIfAlreadyPurchased($this->user, $id);
        if ($count != 0) {
            throw new ValidatorException('You already purchased that voucher.');
        }
        $this->voucherRepository->purchase($this->user, $id);

        return $this->json(['meta' => ['message' => 'purchase successfully']]);
    }
}
