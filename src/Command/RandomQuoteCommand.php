<?php

namespace App\Command;

use App\Repository\CategoryRepository;
use App\Repository\QuoteRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:random-quote',
    description: 'Generate random quote',
)]
class RandomQuoteCommand extends Command
{
    public function __construct(
        private CategoryRepository $categoryRepository,
        private QuoteRepository $quoteRepository
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription("Génération d'une citation")
            ->setHelp('Cette commande permet de générer une citation aléatoirement')

            ->addOption('category', '-c', InputOption::VALUE_REQUIRED, 'Kaamelott, Peaky Blinders or something else');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->section('Quote Generator');

        $input = $input->getOption('category');
        $category = $this->categoryRepository->findOneBy(['name' => $input]);

        if (!$category && $input) {
            $io->error(sprintf('Catégorie %s inconnue', $input));

            return Command::FAILURE;
        }

        $quote = $this->quoteRepository->findRandomQuote($category);

        if (!$quote) {
            $io->error(sprintf('Aucun citation trouvé'));

            return Command::FAILURE;
        }

        $io->text($quote->getContent());
        $io->newLine();
        $io->text($quote->getMeta());
        $io->newLine();

        return Command::SUCCESS;
    }
}
