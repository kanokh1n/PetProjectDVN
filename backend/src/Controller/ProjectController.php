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
use App\Dto\CreateProjectRequest;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class ProjectController extends AbstractController
{
    public function __construct(
        private readonly ProjectService $projectService,
        private readonly Security $security,
        private readonly RequestLogger $requestLogger,
    ){}

    #[Route('/api/project/create', name: 'app_create_project', methods: ['POST'])]
    public function create(Request $request, Security $security, ValidatorInterface $validator, SerializerInterface $serializer): JsonResponse
    {
        $user = $security->getUser();

        try {
            $dto = $serializer->deserialize(
                $request->getContent(),
                CreateProjectRequest::class,
                'json'
            );
        } catch (\Exception $e) {
            $response = $this->json([
                'error' => 'Invalid JSON format',
                'details' => $e->getMessage()
            ], JsonResponse::HTTP_BAD_REQUEST);

            $this->requestLogger->logRequest($request, $response);
            return $response;
        }

        $dto->user = $user;

        $violations = $validator->validate($dto);
        if (count($violations) > 0) {
            $errors = [];
            foreach ($violations as $violation) {
                $errors[$violation->getPropertyPath()] = $violation->getMessage();
            }

            $response = $this->json(['errors' => $errors], JsonResponse::HTTP_BAD_REQUEST);
            $this->requestLogger->logRequest($request, $response);
            return $response;
        }

        try {
            $project = $this->projectService->createProject($dto);

            return $this->json([
                'message' => 'Project created successfully',
                'project' => [
                    'id' => $project->getId(),
                    'title' => $project->getTitle(),
                    'description' => $project->getProjectInfo()->getDescription(),
                    'goal_amount' => $project->getProjectInfo()->getGoalAmount()
                ]
            ], JsonResponse::HTTP_CREATED);
        } catch (\Exception $e) {
            $response = $this->json([
                'error' => 'Project creation failed',
                'details' => $e->getMessage()
            ], JsonResponse::HTTP_BAD_REQUEST);

            $this->requestLogger->logRequest($request, $response);
            return $response;
        }
    }


    #[Route('/api/project/update', name: 'app_update_project', methods: ['PUT'])]
    public function update(Request $request, Security $security): JsonResponse
    {
        try {
            if (!$user = $this->security->getUser()) {
                throw new \Exception('User is not authenticated');
            }

            $projectData = json_decode($request->getContent(), true);

            if (empty($projectData['id'])) {
                throw new \Exception('ProjectId is empty');
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
    /*#[Route('/api/project/{id}', name: 'app_get_project', methods: ['GET'])]
    public function getCurrentProject(int $id, Security $security, Request $request): JsonResponse{

    }*/
}
