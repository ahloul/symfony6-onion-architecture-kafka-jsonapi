<?php

namespace App\Voucher\Domain\Entities;

use App\Repository\Voucher\Domain\Entities\VoucherRepository;
use App\User\Domain\Entities\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity]
class Purchase
{

    #[ORM\Column(type: 'datetime', options: ['default' => 'CURRENT_TIMESTAMP'])]
    private $purchasedAt;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private $redeemed;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'voucherPurchase')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: false)]
    private $user;


    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Voucher::class, inversedBy: 'voucherPurchase')]
    #[ORM\JoinColumn(name: 'voucher_id', referencedColumnName: 'id', nullable: false)]
    private $voucher;

    public function getPurchasedAt(): ?\DateTimeInterface
    {
        return $this->purchasedAt;
    }

    public function setPurchasedAt(\DateTimeInterface $purchasedAt): self
    {
        $this->purchasedAt = $purchasedAt;

        return $this;
    }

    public function getRedeemed(): ?bool
    {
        return $this->redeemed;
    }

    public function setRedeemed(bool $redeemed): self
    {
        $this->redeemed = $redeemed;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getVoucher(): ?Voucher
    {
        return $this->voucher;
    }

    public function setVoucher(?Voucher $voucher): self
    {
        $this->voucher = $voucher;

        return $this;
    }

}
