<?php

namespace App\Controller;

use App\Service\ProjectService;
use App\Utils\CurrentUserTrait;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProjectController extends AbstractController
{
    use CurrentUserTrait;
    private $projectService;

    public function __construct(ProjectService $projectService, Security $security)
    {
        $this->projectService = $projectService;
        $this->security = $security;
    }

    #[Route('/api/project/create', name: 'app_create_project')]
    public function create(Request $request): JsonResponse
    {
        $user = $this->getCurrentUser();

        $projectData = json_decode($request->getContent(), true);

        if (empty($projectData['title'])) {
            return $this->json(['error' => 'Введите обязательные поля'], Response::HTTP_BAD_REQUEST);
        }

        $projectData['user'] = $user;

        try {
            $project = $this->projectService->createProject($projectData);

            return $this->json([
                'message' => 'Проект успешно создан',
                'project' => $project->getId(),
                'userId' => $user->getId()
            ]);
        } catch (\Exception $e) {
            return $this->json([
                'error' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/api/project/update', name: 'app_update_project')]
    public function update(Request $request): JsonResponse
    {
        try {
            $user = $this->getCurrentUser();
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_UNAUTHORIZED);
        }

        $projectData = json_decode($request->getContent(), true);

        if (empty($projectData['id'])) {
            return $this->json(['error' => 'ID проекта не указан'], Response::HTTP_BAD_REQUEST);
        }

        try {
            $projectData['user'] = $user;
            $project = $this->projectService->updateProject($projectData);

            return $this->json([
                'message' => 'Проект успешно обновлен',
                'project' => $project->getId(),
                'userId' => $user->getId()
            ]);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
