<?php
namespace App\Dto;

use App\Validator\UniqueSubmissionPerHour;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
#[UniqueSubmissionPerHour]
class StoreContactDto
{
    #[Assert\NotBlank(message: "Le sujet est obligatoire")]
    #[Assert\Length(max: 255, maxMessage: "Le sujet doit faire moins de 255 caractères")]
    public ?string $subject = null;

    #[Assert\NotBlank(message: "Le message est obligatoire")]
    public ?string $body = null;

    public ?int $user_id = null;

    #[Assert\File(
        maxSize: '2M',
        mimeTypes: [
            'image/jpeg',
            'image/png',
            'application/pdf'
        ],
        mimeTypesMessage: 'Le fichier doit être une image (JPEG, PNG) ou un PDF et ne pas dépasser 2Mo.'
    )]
    public ?UploadedFile $file = null;

}
