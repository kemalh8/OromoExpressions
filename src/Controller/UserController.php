<?php
namespace App\Controller;

use App\Entity\User;
use App\Service\RoleManager; // Import the RoleManager service
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface; 
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface; 

#[IsGranted("ROLE_ADMIN")]
class UserController extends AbstractController
{
    private EntityManagerInterface $entityManager; // Adding the EntityManager
///////// à decommenter apres*private RoleManager $roleManager; // Inject the RoleManager service


    public function __construct(EntityManagerInterface $entityManager, /*RoleManager $roleManager*/)
    {
        $this->entityManager = $entityManager;
///////// à decommenter apres* $this->roleManager = $roleManager;

    }

    #[Route('api/users', name: 'app_user', methods: ['GET'])]
    public function index(SerializerInterface $serializer): JsonResponse
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'You are not allowed to access this resource.');

        $user = $this->getUser();
        return $this->json(json_decode($serializer->serialize($user, 'json')));
    }



    #[Route('/api/register', name: 'api_register', methods: ['POST'])]
    public function register(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        SerializerInterface $serializer
    ): JsonResponse {
        // Step 1: Receive and Validate Input
        $data = json_decode($request->getContent(), true);

        $username = $data['username'];
        $email = $data['email'];
        $plainPassword = $data['password'];
        $firstName = $data['firstname'];
        $lastName = $data['lastname'];
        $number = $data['number'];

        if (empty($username) || empty($email) || empty($plainPassword)) {
            return $this->json(['message' => 'Invalid input. Username, email, and password are required.'], 400);
        }

        // Step 2: i have to create a New User Entity and Set Properties
        $user = new User();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setNumber($number);

        // i have to hash the password for security
        $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
        $user->setPassword($hashedPassword);

        // Step 3: i have to set User Roles 
        $user->setRoles(['ROLE_USER']); // Default role for users

        // Step 4: Persisting to the Database
        $entityManager = $this->entityManager; // Use the injected EntityManager
        $entityManager->persist($user);
        $entityManager->flush();

        $userData = $serializer->serialize($user, 'json', ['groups' => 'registration']);
        $data = json_decode($userData);
        return $this->json(['message' => 'You\'re registered successfully! Time to log in or authenticate !!', 'user' =>$data], 2);
    }



    /*
    // Additional method for handling selling NFTs
    #[Route('/api/sell-nft', name: 'sell_nft', methods: ['POST'])]
    public function sellNFT(Request $request, User $user, RoleManager $roleManager)
    {
        // Logic for selling NFT...
        $nftId = $request->get('nft_id'); // Assuming you receive the NFT ID in the request
        
        // Check if the user is the owner of the NFT (you may need to add security checks)
        $nft = $this->getDoctrine()->getRepository(Nft::class)->find($nftId);

        if (!$nft || $nft->getUser() !== $user) {
            return $this->json(['message' => 'You are not the owner of this NFT.'], 403);
        }

        // Perform the sale logic, update NFT status, transfer payment, etc.
        // ...

        // After a successful sale, assign the seller role
        $roleManager->assignSellerRole($user);

        // Rest of the logic...

        return $this->json(['message' => 'NFT sold successfully!']);
    }



    
    // Additional method for handling buying NFTs
    #[Route('/api/buy-nft', name: 'buy_nft', methods: ['POST'])]
    public function buyNFT(Request $request, User $user, RoleManager $roleManager)
    {
        // Logic for buying NFT...
        $nftId = $request->get('nft_id'); // Assuming you receive the NFT ID in the request
        
        // Check if the NFT is available for purchase and not owned by the user
///////* $nft = $this->getDoctrine()->getRepository(Nft::class)->find($nftId);

        if (!$nft || $nft->getUser() === $user || $nft->getStatus() !== 'available') {
            return $this->json(['message' => 'The NFT is not available for purchase.'], 403);
        }

        // Perform the purchase logic, transfer payment, update NFT ownership, etc.
        // ...

        // After a successful purchase, assign the buyer role
        $roleManager->assignBuyerRole($user);

        // Rest of the logic...

        return $this->json(['message' => 'NFT bought successfully!']);
    }

*/

}
