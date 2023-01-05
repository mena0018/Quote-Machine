<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\QuoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/profile/{id}', name: 'app_profile', methods: ['GET'])]
    public function profile(User $user, QuoteRepository $quoteRepository): Response
    {
        $quotes = $quoteRepository->findLastQuotes($user);

        return $this->render('user/profile.html.twig', [
            'user' => $user,
            'quotes' => $quotes,
        ]);
    }
}
