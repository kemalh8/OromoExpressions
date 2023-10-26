<?php
/// src/Security/CsrfTokenGenerator.php

namespace App\Security;

use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class CsrfTokenGenerator
{
    private $tokenManager;

    public function __construct(CsrfTokenManagerInterface $tokenManager)
    {
        $this->tokenManager = $tokenManager;
    }

    public function generateCsrfToken(string $tokenId): string
    {
        return $this->tokenManager->getToken($tokenId)->getValue();
    }
}
