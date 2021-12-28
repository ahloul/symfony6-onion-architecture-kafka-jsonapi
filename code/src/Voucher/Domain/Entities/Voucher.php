<?php

namespace App\Voucher\Domain\Entities;

use App\Repository\Voucher\Domain\Entities\VoucherRepository;
use App\User\Domain\Entities\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: VoucherRepository::class)]
class Voucher
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $code;

    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    #[Assert\NotNull]
    #[ORM\Column(type: 'decimal', options: ['default' => 0])]
    private $price;

    #[ORM\Column(type: 'integer', options: ['default' => 0])]
    private $quantityInStock;

    #[Assert\DateTime]
    #[ORM\Column(type: 'datetime', options: ['default' => 'CURRENT_TIMESTAMP'])]
    private $vaildFrom;

    #[Assert\DateTime]
    #[ORM\Column(type: 'datetime', options: ['default' => 'CURRENT_TIMESTAMP'])]
    private $validTo;


    #[ORM\OneToMany(mappedBy: 'voucher', targetEntity: Purchase::class)]
    private $voucherPurchase;

    #[ORM\OneToMany(mappedBy: 'voucher', targetEntity: Redeem::class)]
    private $voucherRedeem;

    public function __construct()
    {
        $this->purchase = new ArrayCollection();
        $this->redeem = new ArrayCollection();
        $this->voucherPurchase = new ArrayCollection();
        $this->voucherRedeem = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getQuantityInStock(): ?int
    {
        return $this->quantityInStock;
    }

    public function setQuantityInStock(int $quantityInStock): self
    {
        $this->quantityInStock = $quantityInStock;

        return $this;
    }

    public function getVaildFrom(): ?\DateTimeInterface
    {
        return $this->vaildFrom;
    }

    public function setVaildFrom(\DateTimeInterface $vaildFrom): self
    {
        $this->vaildFrom = $vaildFrom;

        return $this;
    }

    public function getValidTo(): ?\DateTimeInterface
    {
        return $this->validTo;
    }

    public function setValidTo(\DateTimeInterface $validTo): self
    {
        $this->validTo = $validTo;

        return $this;
    }

    /**
     * @return Collection|Purchase[]
     */
    public function getPurchase(): Collection
    {
        return $this->purchase;
    }

    public function addPurchase(Purchase $purchase): self
    {
        if (!$this->purchase->contains($purchase)) {
            $this->purchase[] = $purchase;
            $purchase->setPurchase($this);
        }

        return $this;
    }

    public function removePurchase(Purchase $purchase): self
    {
        if ($this->purchase->removeElement($purchase)) {
            // set the owning side to null (unless already changed)
            if ($purchase->getPurchase() === $this) {
                $purchase->setPurchase(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Redeem[]
     */
    public function getRedeem(): Collection
    {
        return $this->redeem;
    }

    public function addRedeem(Redeem $redeem): self
    {
        if (!$this->redeem->contains($redeem)) {
            $this->redeem[] = $redeem;
            $redeem->setRedeem($this);
        }

        return $this;
    }

    public function removeRedeem(Redeem $redeem): self
    {
        if ($this->redeem->removeElement($redeem)) {
            // set the owning side to null (unless already changed)
            if ($redeem->getRedeem() === $this) {
                $redeem->setRedeem(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Purchase[]
     */
    public function getVoucherPurchase(): Collection
    {
        return $this->voucherPurchase;
    }

    public function addVoucherPurchase(Purchase $voucherPurchase): self
    {
        if (!$this->voucherPurchase->contains($voucherPurchase)) {
            $this->voucherPurchase[] = $voucherPurchase;
            $voucherPurchase->setVoucher($this);
        }

        return $this;
    }

    public function removeVoucherPurchase(Purchase $voucherPurchase): self
    {
        if ($this->voucherPurchase->removeElement($voucherPurchase)) {
            // set the owning side to null (unless already changed)
            if ($voucherPurchase->getVoucher() === $this) {
                $voucherPurchase->setVoucher(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Redeem[]
     */
    public function getVoucherRedeem(): Collection
    {
        return $this->voucherRedeem;
    }

    public function addVoucherRedeem(Redeem $voucherRedeem): self
    {
        if (!$this->voucherRedeem->contains($voucherRedeem)) {
            $this->voucherRedeem[] = $voucherRedeem;
            $voucherRedeem->setVoucher($this);
        }

        return $this;
    }

    public function removeVoucherRedeem(Redeem $voucherRedeem): self
    {
        if ($this->voucherRedeem->removeElement($voucherRedeem)) {
            // set the owning side to null (unless already changed)
            if ($voucherRedeem->getVoucher() === $this) {
                $voucherRedeem->setVoucher(null);
            }
        }

        return $this;
    }
}
