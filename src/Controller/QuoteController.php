<?php

namespace App\Controller;

use App\Entity\Quote;
use App\Repository\QuoteRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/quote')]
class QuoteController extends AbstractController
{
    #[Route('/', name: 'quote_index')]
    public function index(Request $request, QuoteRepository $quoteRepository, PaginatorInterface $paginator): Response
    {
        $searchTerm = $request->query->get("content");
        $queryBuilder = $quoteRepository->createQueryBuilder('q');

        if (!empty($searchTerm)) {
            $queryBuilder->where('q.content LIKE :content')
                ->setParameter('content', '%' . $searchTerm . '%');
        }

        $quotes = $paginator->paginate(
            $queryBuilder->getQuery()->getResult(),
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('quote/index.html.twig', [
            'controller_name' => 'QuoteController',
            'quotes' => $quotes,
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
            $this->addFlash('success', "Citation ajoutée avec succès");
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
                'Aucune citation trouvée pour l\'identifiant '.$id
            );
        }

        if ($request->isMethod('POST')) {
            $quote->setContent($request->request->get("citation"));
            $quote->setMeta($request->request->get("metadata"));

            $entityManager->flush();
            $this->addFlash('success', "Citation modifiée avec succès");
            return $this->redirectToRoute('quote_index');
        }

        return $this->render('quote/edit.html.twig', [
            'controller_name' => 'QuoteController',
            'quote' => $quote
        ]);
    }

    #[Route('/delete/{id}', name: 'quote_delete')]
    public function delete(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $quote = $entityManager->getRepository(Quote::class)->find($id);

        if ($quote) {
            $entityManager->remove($quote);
            $entityManager->flush();
            $this->addFlash('success', "Citation supprimée avec succès");
        } else {
            throw $this->createNotFoundException(
                'Aucune citation trouvée pour l\'identifiant '.$id
            );
        }

        return $this->redirectToRoute('home');
    }
}
