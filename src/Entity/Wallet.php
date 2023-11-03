<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\WalletRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WalletRepository::class)]
#[ApiResource]
class Wallet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'wallets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user_id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0')]
    private ?string $balance = null;

    #[ORM\OneToMany(mappedBy: 'wallet_id', targetEntity: Transaction::class)]
    private Collection $transaactions;

    public function __construct()
    {
        $this->transaactions = new ArrayCollection();
    }

    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getBalance(): ?string
    {
        return $this->balance;
    }

    public function setBalance(string $balance): static
    {
        $this->balance = $balance;

        return $this;
    }

    /**
     * @return Collection<int, Transaction>
     */
    public function getTransaactions(): Collection
    {
        return $this->transaactions;
    }

    public function addTransaaction(Transaction $transaaction): static
    {
        if (!$this->transaactions->contains($transaaction)) {
            $this->transaactions->add($transaaction);
            $transaaction->setWalletId($this);
        }

        return $this;
    }

    public function removeTransaaction(Transaction $transaaction): static
    {
        if ($this->transaactions->removeElement($transaaction)) {
            // set the owning side to null (unless already changed)
            if ($transaaction->getWalletId() === $this) {
                $transaaction->setWalletId(null);
            }
        }

        return $this;
    }


}
