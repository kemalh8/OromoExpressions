<?php
namespace App\Entity;

use ApiPlatform\Metadata\ApiResource; // Import the correct namespace
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
#[ApiResource()]

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column]
    private ?int $number = null;

    #[ORM\Column(length: 255)]
    private ?string $first_name = null;

    #[ORM\Column(length: 255)]
    private ?string $last_name = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $birthdate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $wallet_address = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\OneToMany(mappedBy: 'creator_id', targetEntity: Nft::class)]
    private Collection $createdNfts;

    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: Nft::class)]
    private Collection $soldNfts;

    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: Wallet::class)]
    private Collection $wallets;

    #[ORM\OneToMany(mappedBy: 'seller_id', targetEntity: Transaction::class)]
    private Collection $transactions;

    #[ORM\OneToMany(mappedBy: 'buyer_id', targetEntity: Transaction::class)]
    private Collection $purchasedNfts;

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
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

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }


    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): static
    {
        $this->number = $number;

        return $this;
    }

    
    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): static
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): static
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(?\DateTimeInterface $birthdate): static
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getWalletAddress(): ?string
    {
        return $this->wallet_address;
    }

    public function setWalletAddress(?string $wallet_address): static
    {
        $this->wallet_address = $wallet_address;

        return $this;
    }

    public function __construct()
    {
        $this->createdNfts = new ArrayCollection();
        $this->soldNfts = new ArrayCollection();
        $this->wallets = new ArrayCollection();
        $this->transactions = new ArrayCollection();
        $this->purchasedNfts = new ArrayCollection();
    }


    /**
     * @return Collection<int, Nft>
     */
    public function getCreatedNfts(): Collection
    {
        return $this->createdNfts;
    }

    public function addCreatedNft(Nft $createdNft): static
    {
        if (!$this->createdNfts->contains($createdNft)) {
            $this->createdNfts->add($createdNft);
            $createdNft->setCreatorId($this);
        }

        return $this;
    }

    public function removeCreatedNft(Nft $createdNft): static
    {
        if ($this->createdNfts->removeElement($createdNft)) {
            // set the owning side to null (unless already changed)
            if ($createdNft->getCreatorId() === $this) {
                $createdNft->setCreatorId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Nft>
     */
    public function getSoldNfts(): Collection
    {
        return $this->soldNfts;
    }

    public function addSoldNft(Nft $soldNft): static
    {
        if (!$this->soldNfts->contains($soldNft)) {
            $this->soldNfts->add($soldNft);
            $soldNft->setUserId($this);
        }

        return $this;
    }

    public function removeSoldNft(Nft $soldNft): static
    {
        if ($this->soldNfts->removeElement($soldNft)) {
            // set the owning side to null (unless already changed)
            if ($soldNft->getUserId() === $this) {
                $soldNft->setUserId(null);
            }
        }

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

    /**
     * @return Collection<int, Wallet>
     */
    public function getWallets(): Collection
    {
        return $this->wallets;
    }

    public function addWallet(Wallet $wallet): static
    {
        if (!$this->wallets->contains($wallet)) {
            $this->wallets->add($wallet);
            $wallet->setUserId($this);
        }

        return $this;
    }

    public function removeWallet(Wallet $wallet): static
    {
        if ($this->wallets->removeElement($wallet)) {
            // set the owning side to null (unless already changed)
            if ($wallet->getUserId() === $this) {
                $wallet->setUserId(null);
            }
        }

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
            $transaction->setSellerId($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): static
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getSellerId() === $this) {
                $transaction->setSellerId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Transaction>
     */
    public function getPurchasedNfts(): Collection
    {
        return $this->purchasedNfts;
    }

    public function addPurchasedNft(Transaction $purchasedNft): static
    {
        if (!$this->purchasedNfts->contains($purchasedNft)) {
            $this->purchasedNfts->add($purchasedNft);
            $purchasedNft->setBuyerId($this);
        }

        return $this;
    }

    public function removePurchasedNft(Transaction $purchasedNft): static
    {
        if ($this->purchasedNfts->removeElement($purchasedNft)) {
            // set the owning side to null (unless already changed)
            if ($purchasedNft->getBuyerId() === $this) {
                $purchasedNft->setBuyerId(null);
            }
        }

        return $this;
    }
}
