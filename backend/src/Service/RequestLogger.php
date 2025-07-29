<?php

// src/Service/RequestLogger.php
namespace App\Service;

use App\Entity\RequestLogs;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RequestLogger
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {}

    public function logRequest(Request $request, Response $response): void {

        $log = new RequestLogs();
        $log->setMethod($request->getMethod());
        $log->setPath($request->getPathInfo());
        $log->setStatusCode($response->getStatusCode());
        $log->setError(mb_substr($response->getContent(), 0, 500));
        $this->entityManager->persist($log);
        $this->entityManager->flush();
    }
}
