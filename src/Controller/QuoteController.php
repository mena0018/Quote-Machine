<?php

namespace App\Controller;

use App\Entity\Quote;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/quote')]
class QuoteController extends AbstractController
{
    #[Route('/', name: 'quote_index')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $searchTerm = $request->query->get("content");
        $quotes = $doctrine->getRepository(Quote::class)->findByContent($searchTerm);
        return $this->render('quote/index.html.twig', [
            'controller_name' => 'QuoteController',
            'quotes' => $quotes
        ]);
    }

    #[Route('/new', name: 'quote_new')]
    public function new(ManagerRegistry $doctrine, Request $request): Response
    {
        $entityManager = $doctrine->getManager();

        if ($request->isMethod('POST')) {
            $quote = new Quote();
            $quote->setContent($request->request->get("citation"));
            $quote->setMeta($request->request->get("metadata"));

            $entityManager->persist($quote);
            $entityManager->flush();
            return $this->redirectToRoute('quote_index');
        }

        return $this->render('quote/new.html.twig', [
            'controller_name' => 'QuoteController',
        ]);
    }

    #[Route('/edit/{id}', name: 'quote_edit')]
    public function edit(ManagerRegistry $doctrine, Request $request, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $quote = $entityManager->getRepository(Quote::class)->find($id);

        if (!$quote) {
            throw $this->createNotFoundException(
                'Aucune quote trouvé pour l\'identifiant '.$id
            );
        }

        if ($request->isMethod('POST')) {
            $quote->setContent($request->request->get("citation"));
            $quote->setMeta($request->request->get("metadata"));

            $entityManager->flush();
            return $this->redirectToRoute('quote_index');
        }

        return $this->render('quote/edit.html.twig', [
            'controller_name' => 'QuoteController',
        ]);
    }
}
