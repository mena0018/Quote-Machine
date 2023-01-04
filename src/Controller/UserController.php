<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/profile/{id}', name: 'app_profile', methods: ['GET'])]
    public function profile(User $user, EntityManagerInterface $entityManager): Response
    {
        $query = $entityManager->createQuery(
            'SELECT c
             FROM App\Entity\Quote c
             WHERE c.author = :author
             ORDER BY c.createdAt DESC'
        )
            ->setParameter('author', $user)
            ->setMaxResults(5);

        return $this->render('user/profile.html.twig', [
            'user' => $user,
            'quotes' => $query->getResult(),
        ]);
    }
}
