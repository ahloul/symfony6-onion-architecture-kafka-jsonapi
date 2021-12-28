<?php

namespace App\User\Domain\Entities;

use App\Voucher\Domain\Entities\Purchase;
use App\Voucher\Domain\Entities\Redeem;
use App\Voucher\Domain\Entities\Voucher;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity]
#[ORM\Table(name: '`user`')]
#[ORM\HasLifecycleCallbacks]
class User implements UserInterface,PasswordAuthenticatedUserInterface
{


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;


    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 5, max: 255)]
    private $email;


    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    private $password;


    #[ORM\Column(type: 'string', length: 255,options: ['default'=>'free'])]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    private $tier;


    #[ORM\ManyToMany(targetEntity: Voucher::class, inversedBy: 'user')]
    #[ORM\JoinTable(name: 'users_vouchers')]
    private $vouchers;


    #[ORM\Column(type: 'json')]
    private $roles = [];


    #[ORM\OneToMany(mappedBy: 'purchase', targetEntity: Purchase::class)]
    private $voucherPurchase;

    #[ORM\OneToMany(mappedBy: 'redeem', targetEntity: Redeem::class)]
    private $voucherRedeem;

    public function __construct()
    {
        $this->vouchers = new ArrayCollection();
        $this->voucherPurchase = new ArrayCollection();
        $this->voucherRedeem = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getEmail(): string
    {
        return (string)$this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }





    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials()
    {

    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }
    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @return Collection|Voucher[]
     */
    public function getVouchers(): Collection
    {
        return $this->vouchers;
    }

    public function addVoucher(Voucher $voucher): self
    {
        if (!$this->vouchers->contains($voucher)) {
            $this->vouchers[] = $voucher;
        }

        return $this;
    }

    public function removeVoucher(Voucher $voucher): self
    {
        $this->vouchers->removeElement($voucher);

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
     * @return Collection|Voucher[]
     */
    public function getVoucherPurchase(): Collection
    {
        return $this->voucherPurchase;
    }

    public function addVoucherPurchase(Redeem $voucherPurchase): self
    {
        if (!$this->voucherPurchase->contains($voucherPurchase)) {
            $this->voucherPurchase[] = $voucherPurchase;
            $voucherPurchase->setRedeem($this);
        }

        return $this;
    }

    public function removeVoucherPurchase(Redeem $voucherPurchase): self
    {
        if ($this->voucherPurchase->removeElement($voucherPurchase)) {
            // set the owning side to null (unless already changed)
            if ($voucherPurchase->getRedeem() === $this) {
                $voucherPurchase->setRedeem(null);
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
            $voucherRedeem->setRedeem($this);
        }

        return $this;
    }

    public function removeVoucherRedeem(Redeem $voucherRedeem): self
    {
        if ($this->voucherRedeem->removeElement($voucherRedeem)) {
            // set the owning side to null (unless already changed)
            if ($voucherRedeem->getRedeem() === $this) {
                $voucherRedeem->setRedeem(null);
            }
        }

        return $this;
    }

    public function getTier(): ?string
    {
        return $this->tier;
    }

    public function setTier(string $tier): self
    {
        $this->tier = $tier;

        return $this;
    }
}
