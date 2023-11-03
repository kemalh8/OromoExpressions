<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\NftRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: NftRepository::class)]
#[ApiResource]
class Nft
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 10,
        max: 50,
        minMessage: 'The number of the description is less than {{limit}} characters ',
        maxMessage: 'The number of the description exceeds {{limit}} characters',
    )]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank]
    private ?\DateTimeInterface $creationDate = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    private ?float $price = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $imageUrl = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $status = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\Column(nullable: true)]
    private ?int $token_id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $token_contract_address = null;

    #[ORM\ManyToOne(inversedBy: 'createdNfts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $creator_id = null;

    #[ORM\ManyToOne(inversedBy: 'soldNfts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user_id = null;

    #[ORM\ManyToOne(inversedBy: 'nfts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category_id = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'nfts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?self $parentNft = null;

    #[ORM\OneToMany(mappedBy: 'parentNft', targetEntity: self::class)]
    private Collection $nfts;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'nfts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?self $childNfts = null;

    #[ORM\OneToMany(mappedBy: 'nft_id', targetEntity: Transaction::class)]
    private Collection $transactions;

    public function __construct()
    {
        $this->nfts = new ArrayCollection();
        $this->transactions = new ArrayCollection();
    }

   


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): static
    {
        $this->creationDate = $creationDate;

        return $this;
    }

  

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): static
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getTokenId(): ?int
    {
        return $this->token_id;
    }

    public function setTokenId(?int $token_id): static
    {
        $this->token_id = $token_id;

        return $this;
    }

    public function getTokenContractAddress(): ?string
    {
        return $this->token_contract_address;
    }

    public function setTokenContractAddress(?string $token_contract_address): static
    {
        $this->token_contract_address = $token_contract_address;

        return $this;
    }

    public function getCreatorId(): ?User
    {
        return $this->creator_id;
    }

    public function setCreatorId(?User $creator_id): static
    {
        $this->creator_id = $creator_id;

        return $this;
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

    public function getCategoryId(): ?Category
    {
        return $this->category_id;
    }

    public function setCategoryId(?Category $category_id): static
    {
        $this->category_id = $category_id;

        return $this;
    }

    public function getParentNft(): ?self
    {
        return $this->parentNft;
    }

    public function setParentNft(?self $parentNft): static
    {
        $this->parentNft = $parentNft;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getNfts(): Collection
    {
        return $this->nfts;
    }

    public function addNft(self $nft): static
    {
        if (!$this->nfts->contains($nft)) {
            $this->nfts->add($nft);
            $nft->setParentNft($this);
        }

        return $this;
    }

    public function removeNft(self $nft): static
    {
        if ($this->nfts->removeElement($nft)) {
            // set the owning side to null (unless already changed)
            if ($nft->getParentNft() === $this) {
                $nft->setParentNft(null);
            }
        }

        return $this;
    }

    public function getChildNfts(): ?self
    {
        return $this->childNfts;
    }

    public function setChildNfts(?self $childNfts): static
    {
        $this->childNfts = $childNfts;

        return $this;
    }

    /**
     * @return Collection<int, Transaction>
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): static
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions->add($transaction);
            $transaction->setNftId($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): static
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getNftId() === $this) {
                $transaction->setNftId(null);
            }
        }

        return $this;
    }


}
