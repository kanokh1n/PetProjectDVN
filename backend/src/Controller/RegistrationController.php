<?php

namespace App\Controller;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\UserService;

final class RegistrationController extends AbstractController
{
    private $userService;
    private $jwtManager;

    public function __construct(UserService $userService, JWTTokenManagerInterface $jwtManager) {
        $this->userService = $userService;
        $this->jwtManager = $jwtManager;
    }

    #[Route('/api/register', name: 'app_register', methods: ['POST'])]
    public function register(Request $request): JsonResponse
    {
        $userData = json_decode($request->getContent(), true);

        if (empty($userData['email']) || empty($userData['password'])) {
            return $this->json(
                ['error' => 'Email or password are required'],
                Response::HTTP_BAD_REQUEST
            );
        }

        $email = $userData['email'];
        $password = $userData['password'];

        try {
            $user = $this->userService->registerUser($email, $password);
            $token = $this->jwtManager->create($user);

            return $this->json([
                'message' => 'Вы успешно зарегистрировались',
                'token' => $token,
                'user' => $user->getId(),
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return $this->json([
                'error' => $e->getMessage()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}
