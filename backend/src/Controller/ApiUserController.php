<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiUserController extends AbstractController
{
    #[Route('/api/users', name: 'api_users', methods: ['GET'])]
    public function getUsers(UserRepository $userRepository): JsonResponse
    {
        $users = $userRepository->findAll();

        // Преобразуем объекты User в массив
        $data = [];
        foreach ($users as $user) {
            $data[] = [
                'id' => $user->getId(),
                'name' => $user->getName(),
                'email' => $user->getEmail(),
            ];
        }

        return $this->json($data);
    }
}