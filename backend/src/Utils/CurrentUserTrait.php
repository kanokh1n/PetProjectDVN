<?php

namespace App\Utils;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

trait CurrentUserTrait
{
    private Security $security;

    /**
     * Получает текущего пользователя
     *
     * @return UserInterface
     * @throws \Exception
     */
    protected function getCurrentUser(): UserInterface
    {
        $user = $this->security->getUser();

        if (!$user) {
            throw new \Exception('Пользователь не найден');
        }

        return $user;
    }

}
