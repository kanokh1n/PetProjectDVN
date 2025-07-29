<?php

namespace App\Controller;

use App\Service\RequestLogger;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\UserService;

final class RegistrationController extends AbstractController
{
    public function __construct(
        private readonly UserService $userService,
        private readonly JWTTokenManagerInterface $jwtManager,
        private readonly RequestLogger $requestLogger
    ){}

    #[Route('/api/register', name: 'app_register', methods: ['POST'])]
    public function register(Request $request): JsonResponse
    {
        $userData = json_decode($request->getContent(), true);

        try {
            if (empty($userData['email']) || empty($userData['password'])) {
                throw new \Exception('Email and password are required');
            }

            $email = $userData['email'];
            $password = $userData['password'];

            $user = $this->userService->registerUser($email, $password);
            $token = $this->jwtManager->create($user);

            return $this->json([
                'message' => 'Registration successful',
                'token' => $token,
                'user' => $user->getId(),
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            $response = $this->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
            $this->requestLogger->logRequest($request, $response);
            return $response;
        }
    }
}
