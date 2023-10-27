<?php
namespace App\Controller;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface; 
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface; 


class UserController extends AbstractController
{
    private EntityManagerInterface $entityManager; // Adding the EntityManager

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('api/users', name: 'app_user', methods: ['GET'])]
    #[IsGranted("ROLE_ADMIN")]
    public function index(SerializerInterface $serializer): JsonResponse
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'You are not allowed to access this resource.');

        $user = $this->getUser();
        return $this->json(json_decode($serializer->serialize($user, 'json')));
    }



    #[Route('/api/register', name: 'api_register', methods: ['POST'])]
    public function register(
        Request $request,
        UserPasswordHasherInterface $passwordHasher
    ): JsonResponse {
        // Step 1: Receive and Validate Input
        $data = json_decode($request->getContent(), true);

        $username = $data['username'];
        $email = $data['email'];
        $plainPassword = $data['password'];
        $country = $data['country'];
        $city = $data['city'];
        $number = $data['number'];

        if (empty($username) || empty($email) || empty($plainPassword)) {
            return $this->json(['message' => 'Invalid input. Username, email, and password are required.'], 400);
        }

        // Step 2: i have to create a New User Entity and Set Properties
        $user = new User();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setCountry($country);
        $user->setCity($city);
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

        return $this->json(['message' => 'You\'re registered successfully! Time to log in or authenticate !!']);
    }
}
