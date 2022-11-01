<?php

namespace App\Controller;

use App\Entity\Quote;
use App\Form\QuoteType;
use App\Repository\QuoteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/quote')]
class QuoteController extends AbstractController
{
    #[Route('/', name: 'quote_index')]
    public function index(Request $request, QuoteRepository $quoteRepository, PaginatorInterface $paginator): Response
    {
        $searchTerm = $request->query->get('content');
        $queryBuilder = $quoteRepository->createQueryBuilder('q');

        if (!empty($searchTerm)) {
            $queryBuilder->where('q.content LIKE :content')
                ->setParameter('content', '%'.$searchTerm.'%');
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
    public function new(EntityManagerInterface $entityManager, Request $request): Response
    {
        $quote = new Quote();
        $form = $this->createForm(QuoteType::class, $quote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($quote);
            $entityManager->flush();

            $this->addFlash('success', 'Citation ajoutée avec succès');

            return $this->redirectToRoute('quote_index');
        }

        return $this->render('quote/new.html.twig', [
            'quoteForm' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'quote_show', methods: ['GET'])]
    public function show(Quote $quote): Response
    {
        return $this->render('quote/show.html.twig', ['quote' => $quote]);
    }

    #[Route('/edit/{id}', name: 'quote_edit')]
    public function edit(EntityManagerInterface $entityManager, Request $request, int $id): Response
    {
        $quote = $entityManager->getRepository(Quote::class)->find($id);

        if (!$quote) {
            throw $this->createNotFoundException('Aucune citation trouvée pour l\'identifiant '.$id);
        }

        $form = $this->createForm(QuoteType::class, $quote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($quote);
            $entityManager->flush();

            $this->addFlash('success', 'Citation modifiée avec succès');

            return $this->redirectToRoute('quote_index');
        }

        return $this->render('quote/edit.html.twig', [
            'quoteForm' => $form->createView(),
        ]);
    }

    #[Route('/delete/{id}', name: 'quote_delete')]
    public function delete(EntityManagerInterface $entityManager, int $id): Response
    {
        $quote = $entityManager->getRepository(Quote::class)->find($id);

        if ($quote) {
            $entityManager->remove($quote);
            $entityManager->flush();
            $this->addFlash('success', 'Citation supprimée avec succès');
        } else {
            throw $this->createNotFoundException('Aucune citation trouvée pour l\'identifiant '.$id);
        }

        return $this->redirectToRoute('home');
    }

    #[Route('/random', name: 'quote_random')]
    public function random(EntityManagerInterface $entityManager): Response
    {
        $qb = $entityManager->createQueryBuilder();
        $qb->select('q.id');
        $qb->from('App:Quote', 'q');

        $res = $qb->getQuery()->getResult();
        $flatRes = array_column($res, 'id');
        $id = $res[array_rand($flatRes, 1)];

        $quote = $entityManager->getRepository(Quote::class)->find($id);

        return $this->render('quote/random.html.twig', [
            'quote' => $quote,
        ]);
    }
}
