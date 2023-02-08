<?php

namespace App\Tests\Command;

use App\Factory\CategoryFactory;
use App\Factory\QuoteFactory;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Zenstruck\Foundry\Test\Factories;

class RandomQuoteCommandTest extends KernelTestCase
{
    use Factories;
    private Application $application;

    public function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->application = new Application($kernel);
    }

    public function testRandomQuoteNotFound()
    {
        // On crée une catégorie sans citation
        CategoryFactory::new()->create(['name' => 'Kaamelott']);

        $command = $this->application->find('app:random-quote');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            '--category' => 'Kaamelott',
        ]);

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Aucune citation trouvé', $output);
    }

    public function testRandomQuoteWithoutArgument()
    {
        // On crée une citation en bd
        QuoteFactory::new()->create([]);

        $command = $this->application->find('app:random-quote');
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        $commandTester->assertCommandIsSuccessful();
    }

    public function testRandomQuoteWithArgument()
    {
        // On crée une citation en bd
        QuoteFactory::new()->create([
            'content' => 'citation de Kaamelott',
            'category' => CategoryFactory::new()->create(['name' => 'Kaamelott']),
        ]);

        $command = $this->application->find('app:random-quote');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            '--category' => 'Kaamelott',
        ]);

        $output = $commandTester->getDisplay();
        $commandTester->assertCommandIsSuccessful();
        $this->assertStringContainsString('citation de Kaamelott', $output);
    }

    public function testRandomQuoteWithBadArgument()
    {
        // On crée une citation en bd
        QuoteFactory::new()->create([
            'content' => 'citation de Kaamelott',
            'category' => CategoryFactory::new()->create(['name' => 'Kaamelott']),
        ]);

        $command = $this->application->find('app:random-quote');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            '--category' => 'BadCategory',
        ]);

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Catégorie BadCategory inconnue', $output);
    }
}
