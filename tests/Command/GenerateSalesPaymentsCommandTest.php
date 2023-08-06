<?php

namespace App\Tests\Command;

use App\Command\GenerateSalesPaymentsCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class GenerateSalesPaymentsCommandTest extends KernelTestCase
{
    public function testExecute()
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);
        $application->add(new GenerateSalesPaymentsCommand());

        $command = $application->find('app:generate-sales-payments');
        $commandTester = new CommandTester($command);

        $commandTester->execute([
            'command' => $command->getName(),
            // Add any necessary input options here
        ]);

        // Assert the expected output or behavior
        $this->assertContains('Generated data:', $commandTester->getDisplay());
        // Add more assertions as needed
    }
}
