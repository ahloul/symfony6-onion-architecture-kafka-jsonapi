<?php

namespace App\Controller;

use App\Voucher\Domain\Entities\Voucher;
use App\JsonApi\Document\Voucher\VoucherDocument;
use App\JsonApi\Document\Voucher\VouchersDocument;
use App\JsonApi\Hydrator\Voucher\CreateVoucherHydrator;
use App\JsonApi\Hydrator\Voucher\UpdateVoucherHydrator;
use App\JsonApi\Transformer\VoucherResourceTransformer;
use App\Repository\Voucher\Domain\Entities\VoucherRepository;
use Paknahad\JsonApiBundle\Controller\Controller;
use Paknahad\JsonApiBundle\Helper\ResourceCollection;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/vouchers")
 */
class VoucherController extends Controller
{
    /**
     * @Route("/", name="vouchers_index", methods="GET")
     */
    public function index(VoucherRepository $voucherRepository, ResourceCollection $resourceCollection): Response
    {
        $resourceCollection->setRepository($voucherRepository);

        $resourceCollection->handleIndexRequest();

        return $this->respondOk(
            new VouchersDocument(new VoucherResourceTransformer()),
            $resourceCollection
        );
    }

    /**
     * @Route("/", name="vouchers_new", methods="POST")
     */
    public function new(): Response
    {
        $voucher = $this->jsonApi()->hydrate(
            new CreateVoucherHydrator($this->entityManager, $this->jsonApi()->getExceptionFactory()),
            new Voucher()
        );

        $this->validate($voucher);

        $this->entityManager->persist($voucher);
        $this->entityManager->flush();

        return $this->respondOk(
            new VoucherDocument(new VoucherResourceTransformer()),
            $voucher
        );
    }

    /**
     * @Route("/{id}", name="vouchers_show", methods="GET")
     */
    public function show(Voucher $voucher): Response
    {
        return $this->respondOk(
            new VoucherDocument(new VoucherResourceTransformer()),
            $voucher
        );
    }

    /**
     * @Route("/{id}", name="vouchers_edit", methods="PATCH")
     */
    public function edit(Voucher $voucher): Response
    {
        $voucher = $this->jsonApi()->hydrate(
            new UpdateVoucherHydrator($this->entityManager, $this->jsonApi()->getExceptionFactory()),
            $voucher
        );

        $this->validate($voucher);

        $this->entityManager->flush();

        return $this->respondOk(
            new VoucherDocument(new VoucherResourceTransformer()),
            $voucher
        );
    }

    /**
     * @Route("/{id}", name="vouchers_delete", methods="DELETE")
     */
    public function delete(Voucher $voucher): Response
    {
        $this->entityManager->remove($voucher);
        $this->entityManager->flush();

        return $this->respondNoContent();
    }
}
