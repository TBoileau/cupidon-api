<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Entity\User;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

#[AsController]
final class UploadAvatar
{
    public function __construct(private TokenStorageInterface $tokenStorage)
    {
    }

    public function __invoke(Request $request): User
    {
        /** @var TokenInterface $token */
        $token = $this->tokenStorage->getToken();

        /** @var User $user */
        $user = $token->getUser();

        /** @var ?UploadedFile $uploadedFile */
        $uploadedFile = $request->files->get('file');

        if (null === $uploadedFile) {
            return $user;
        }

        $user->setFile($uploadedFile);

        return $user;
    }
}
