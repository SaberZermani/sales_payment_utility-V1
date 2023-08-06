<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Process\Process;

class SalesPaymentController extends AbstractController
{
    public function generateSalesPayments(Request $request): JsonResponse
    {
        // Get input parameters from the request
        
        $outputFile = $request->request->get('outputFile');

        $consolePath = __DIR__ . '/../../bin/console';
        $filePath = __DIR__ . '/../../outputfile/paymentFiles.csv';
        $process = new Process(['php', $consolePath, 'app:generate-sales-payments',  $filePath]);
        try {
            $process->mustRun();
            $generatedData = $process->getOutput();
        } catch (ProcessFailedException $exception) {
            $errorMessage = $exception->getMessage();
            return new JsonResponse(['error' => $errorMessage], 500);
        }
       

        // Return the command output as JSON response
        return new JsonResponse(['output' => $generatedData]);
    }
}
