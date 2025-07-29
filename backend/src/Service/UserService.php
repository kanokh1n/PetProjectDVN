<?php

namespace App\Service;

use App\Repository\UserRepository;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UserPasswordHasherInterface $passwordHasher
    ) {}

    public function registerUser(string $email, string $password): User
    {
        if ($this->userRepository->existsByEmail($email)) {
            throw new \Exception('Пользователь с таким email уже существует');
        }

        $user = new User();
        $user->setEmail($email);
        $user->setPassword($this->passwordHasher->hashPassword($user, $password));

        $em = $this->userRepository->getEntityManager();
        $em->persist($user);
        $em->flush();

        return $user;
    }
}
