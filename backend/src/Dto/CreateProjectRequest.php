<?php
namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class CreateProjectRequest
{
    #[Assert\NotBlank(message: 'Title is required')]
    #[Assert\Length(min: 3, minMessage: 'Title must be at least {{ limit }} characters')]
    public string $title;

    #[Assert\Length(max: 1000, maxMessage: 'Description cannot exceed {{ limit }} characters')]
    public string $description = '';

    #[Assert\Positive(message: 'Goal amount must be positive')]
    public int $goalAmount;

    public int $currentAmount = 0;

    #[Assert\Url(message: "Telegram link must be a valid URL.")]
    public string $tgLink = '';

    #[Assert\Url(message: "Github link must be a valid URL.")]
    public string $githubLink = '';

    public ?object $user = null;
}
