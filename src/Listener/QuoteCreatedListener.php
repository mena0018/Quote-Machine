<?php

namespace App\Listener;

use App\Event\QuoteCreatedEvent;
use App\Repository\QuoteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener]
class QuoteCreatedListener
{
    public function __construct(
    private EntityManagerInterface $entityManager,
    private QuoteRepository $quoteRepository
  ) {
    }

    public function __invoke(QuoteCreatedEvent $event): void
    {
        $quote = $event->getQuote();
        $author = $quote->getAuthor();
        $experience = $author->getExperience();

        $userNeverPost = 1 === $this->quoteRepository->count([
          'category' => $quote->getCategory(),
          'author' => $author,
        ]);

        $userNeverPost ? $author->setExperience($experience + 120) : $author->setExperience($experience + 100);

        $this->entityManager->flush();
    }
}
