<?php

namespace App\Controller;

use App\Entity\Nft;
use Doctrine\ORM\EntityManagerInterface; // Import the EntityManagerInterface
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class NftController extends AbstractController
{
    private $entityManager; // Private property to hold the entity manager

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/api/nfts/upload', name: 'api_nft_upload', methods: ['POST'])]
    public function upload(Request $request, SluggerInterface $slugger): Response
    {
        // Handle file upload here
        $imageFile = $request->files->get('imageFile'); // Make sure the input name matches your API request

        if ($imageFile instanceof UploadedFile) {
            // Generate a unique name for the file
            $newFilename = md5(uniqid()) . '.' . $imageFile->guessExtension();

            // Move the file to the desired directory (assets/images)
            $imageFile->move(
                $this->getParameter('nft_image_directory'),
                $newFilename
            );

            // Create an NFT entity and set the image URL
            $nft = new Nft();
            $nft->setImageUrl('/assets/images/' . $newFilename);

            // Save the NFT entity with the image URL using the entity manager
            $this->entityManager->persist($nft);
            $this->entityManager->flush();

            return $this->json(['message' => 'File uploaded successfully']);
        }

        return $this->json(['message' => 'File upload failed'], Response::HTTP_BAD_REQUEST);
    }
}
