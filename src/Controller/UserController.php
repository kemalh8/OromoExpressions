<?php
// src/Controller/UserController.php

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Doctrine\ORM\EntityManagerInterface; 
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface; 


class UserController extends AbstractController
{
    private EntityManagerInterface $entityManager; // Add the EntityManager

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('api/users', name: 'app_user', methods: ['GET'])]
    #[IsGranted("ROLE_ADMIN")]
    public function index(SerializerInterface $serializer): JsonResponse
    {
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

        // Step 2: Create a New User Entity and Set Properties
        $user = new User();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setCountry($country);
        $user->setCity($city);
        $user->setNumber($number);

        // Hash the password for security
        $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
        $user->setPassword($hashedPassword);

        // Step 3: Set User Roles (if needed)
        // In your case, you can set roles for admin or user as needed
        $user->setRoles(['ROLE_USER']); // Default role for users

        // Step 4: Persist to the Database
        $entityManager = $this->entityManager; // Use the injected EntityManager
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->json(['message' => 'User registered successfully']);
    }
}
