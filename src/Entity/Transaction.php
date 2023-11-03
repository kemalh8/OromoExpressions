<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TransactionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
#[ApiResource]
class Transaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $transaction_date = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0')]
    private ?string $transaction_amount = null;

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\ManyToOne(inversedBy: 'transactions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Nft $nft_id = null;

    #[ORM\ManyToOne(inversedBy: 'transactions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $seller_id = null;

    #[ORM\ManyToOne(inversedBy: 'purchasedNfts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $buyer_id = null;

    #[ORM\ManyToOne(inversedBy: 'transaactions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Wallet $wallet_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTransactionDate(): ?\DateTimeInterface
    {
        return $this->transaction_date;
    }

    public function setTransactionDate(\DateTimeInterface $transaction_date): static
    {
        $this->transaction_date = $transaction_date;

        return $this;
    }

    public function getTransactionAmount(): ?string
    {
        return $this->transaction_amount;
    }

    public function setTransactionAmount(string $transaction_amount): static
    {
        $this->transaction_amount = $transaction_amount;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getNftId(): ?Nft
    {
        return $this->nft_id;
    }

    public function setNftId(?Nft $nft_id): static
    {
        $this->nft_id = $nft_id;

        return $this;
    }

    public function getSellerId(): ?User
    {
        return $this->seller_id;
    }

    public function setSellerId(?User $seller_id): static
    {
        $this->seller_id = $seller_id;

        return $this;
    }

    public function getBuyerId(): ?User
    {
        return $this->buyer_id;
    }

    public function setBuyerId(?User $buyer_id): static
    {
        $this->buyer_id = $buyer_id;

        return $this;
    }

    public function getWalletId(): ?Wallet
    {
        return $this->wallet_id;
    }

    public function setWalletId(?Wallet $wallet_id): static
    {
        $this->wallet_id = $wallet_id;

        return $this;
    }
}
