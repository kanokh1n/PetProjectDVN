<?php

namespace App\Service;

use App\Entity\UserProfile;
use App\Repository\UserRepository;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly UserPasswordHasherInterface $passwordHasher
    ) {}

    public function registerUser(string $email, string $password): User
    {
        if ($this->userRepository->existsByEmail($email)) {
            throw new \Exception('User with this email already exists');
        }

        $user = new User();
        $profile = new UserProfile();
        $user->setEmail($email);
        $user->setPassword($this->passwordHasher->hashPassword($user, $password));
        $user->setUserProfile($profile);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}
