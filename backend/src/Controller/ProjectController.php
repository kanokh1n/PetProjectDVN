<?php

namespace App\Controller;

use App\Service\ProjectService;
use App\Service\RequestLogger;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProjectController extends AbstractController
{
    public function __construct(
        private readonly ProjectService $projectService,
        private readonly Security $security,
        private readonly RequestLogger $requestLogger
    ){}

    #[Route('/api/project/create', name: 'app_create_project', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $user = $this->getUser();
        $projectData = json_decode($request->getContent(), true);

        try {
            if (empty($projectData['title'])) {
                throw new \Exception('Title is required');
            }

            $projectData['user'] = $user;
            $project = $this->projectService->createProject($projectData);

            return $this->json([
                'message' => 'Project created successfully',
                'project' => $project->getTitle(),
                'userId' => $user->getId()
            ]);
        } catch (\Exception $e) {
            $response = $this->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
            $this->requestLogger->logRequest($request, $response);
            return $response;
        }
    }

    #[Route('/api/project/update', name: 'app_update_project', methods: ['PUT'])]
    public function update(Request $request): JsonResponse
    {
        try {
            if (!$user = $this->security->getUser()) {
                throw new \Exception('User is not authenticated');
            }

            $projectData = json_decode($request->getContent(), true);

            if (empty($projectData['id'])) {
                throw new \Exception('Title is required');
            }

            $projectData['user'] = $user;
            $project = $this->projectService->updateProject($projectData);

            return $this->json([
                'message' => 'Project updated successfully',
                'project' => $project->getId(),
                'userId' => $user->getId()
            ]);
        } catch (\Exception $e) {
            $response = $this->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
            $this->requestLogger->logRequest($request, $response);
            return $response;
        }
    }
}
