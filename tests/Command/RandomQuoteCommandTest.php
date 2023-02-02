<?php

namespace App\Tests\Command;

use App\Factory\CategoryFactory;
use App\Factory\QuoteFactory;
use App\Factory\UserFactory;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Zenstruck\Foundry\Test\Factories;

class RandomQuoteCommandTest extends KernelTestCase
{
    use Factories;

    public function testCommandWithArgument()
    {
        // $kernel = self::bootKernel();
        // $application = new Application($kernel);

        // // On crée une catégorie en bd
        // $user = UserFactory::createOne()->object();
        // $category = CategoryFactory::createOne(['name' => 'Kaamelott'])->object();
        // QuoteFactory::createOne(['author' => $user, 'category' => $category])->object();

        // $command = $application->find('app:random-quote');
        // $commandTester = new CommandTester($command);
        // $commandTester->execute([
        //   '--category' => 'Kaamelott',
        // ]);

        // $output = $commandTester->getDisplay();
        // $commandTester->assertCommandIsSuccessful();
        // $this->assertStringContainsString('Kaamelott', $output);
    }
}
