<?php

namespace App\Command;

use DateTime;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Process\Process;

class SalesPaymentCommand extends Command
{
    protected static $defaultName = 'app:generate-sales-payments';

    protected function configure()
    {
        $this
            ->setDescription('Generate Sales payment dates.')
            ->setHelp('This command generates sales payment dates as per the given requirements.')
            ->addArgument('output', InputArgument::OPTIONAL, 'Output file name', 'sales_payments.csv');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //Read Command Line argument
        $io = new SymfonyStyle($input, $output);
        $outputFileName = $input->getArgument('output');

        if (!file_exists($outputFileName)) {
           // $helper = new QuestionHelper();
            //$question = new ConfirmationQuestion("The output file '$outputFileName' does not exist. Do you want to generate it? (y/n) ", false);

            //if (!$helper->ask($input, $output, $question)) {
               
                $io->error('Operation aborted. Payment file not exist.');
                exit;
           // }
        }

        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        $currentYear = date('Y');
        $currentMonth = date('n');

        // Check if all months are already processed
        $processedMonths = [];
        $existingData = [];

        if (file_exists($outputFileName)) {
            $existingData = array_map('str_getcsv', file($outputFileName));
            array_shift($existingData); // Remove header
            foreach ($existingData as $row) {
                $processedMonths[] = array_search($row[0], $months) + 1;
            }
        }

        $missingMonths = array_diff(range($currentMonth, 12), $processedMonths);

        if (empty($missingMonths)) {
            $io->success('All months are already processed.');
            return Command::SUCCESS;
        }
        //Calculate Payment
        $fileData = [];
        foreach ($months as $index => $monthName) {
            //All Rows (Months) are insered By Order in outPut File
            if (in_array($index + 1, $missingMonths)) {
                //Calculate Base Salary
                $baseSalaryDate = new DateTime("last day of $monthName $currentYear");
                if ($baseSalaryDate->format('N') >= 6) { // Saturday or Sunday
                    $baseSalaryDate->modify('last friday');
                }
                //Calculate Bonus
                $bonusPaymentDate = new DateTime("15th $monthName $currentYear");
                if ($bonusPaymentDate->format('N') >= 6) { // Saturday or Sunday
                    $bonusPaymentDate->modify('next wednesday');
                }

                $fileData[] = [$monthName, $baseSalaryDate->format('Y-m-d'), $bonusPaymentDate->format('Y-m-d')];
            } else {
        
                foreach ($existingData as $row) {
                    if ($row[0] === $monthName) {
                        $fileData[] = $row;
                        break;
                    }
                }
            }
        }

        $file = fopen($outputFileName, 'w');
        fputcsv($file, ['Month', 'Sales Payment Date', 'Bonus Payment Date']);
        foreach ($fileData as $row) {
            fputcsv($file, $row);
        }
        
        fclose($file);

        $io->success("Sales payment dates for the missing months have been generated and saved to $outputFileName.");
        $io->section('Missing Months:');
        $io->table(['Month'], array_map(fn ($month) => [$month], $missingMonths));
        $io->section('File Content:');
            $io->table(array_keys(reset($fileData)), $fileData);
    
        return Command::SUCCESS;
    }
}
