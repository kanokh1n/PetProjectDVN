<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class UpdateProjectRequest
{
    #[Assert\NotBlank(message: "ID is required.", groups: ['update'])]
    #[Assert\Type("integer")]
    public ?int $id = null;

    #[Assert\Length(max: 255, maxMessage: "Title cannot be longer than 255 characters.")]
    public ?string $title = null;

    #[Assert\Length(max: 1000)]
    public ?string $description = null;

    #[Assert\Url(message: "Must be a valid URL.")]
    public ?string $githubLink = null;

    #[Assert\Url(message: "Must be a valid URL.")]
    public ?string $tgLink = null;

    #[Assert\Positive(message: "Must be greater than zero.")]
    public ?float $goalAmount = null;

    public ?object $user = null;
}
