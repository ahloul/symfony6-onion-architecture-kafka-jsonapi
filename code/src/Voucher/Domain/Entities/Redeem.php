<?php

namespace App\Voucher\Domain\Entities;

use App\Repository\Voucher\Domain\Entities\VoucherRepository;
use App\User\Domain\Entities\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity]
class Redeem
{

    #[ORM\Column(type: 'datetime', options: ['default' => 'CURRENT_TIMESTAMP'])]
    private $reedemedAt;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'voucherRedeem')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: false)]
    private $user;


    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Voucher::class, inversedBy: 'voucherRedeem')]
    #[ORM\JoinColumn(name: 'voucher_id', referencedColumnName: 'id', nullable: false)]
    private $voucher;



    public function __construct()
    {
    }

    public function getReedemedAt(): ?\DateTimeInterface
    {
        return $this->reedemedAt;
    }

    public function setReedemedAt(\DateTimeInterface $reedemedAt): self
    {
        $this->reedemedAt = $reedemedAt;

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
