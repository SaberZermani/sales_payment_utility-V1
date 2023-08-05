# Sales Payment Utility

This is a small command-line utility to generate sales payment dates for a fictional company's sales department.

## Prerequisites

- PHP >= 8.0
- [Composer](https://getcomposer.org/)
- Symfony >= 6.0

## Getting Started

1. Clone the repository to your local machine:

   ```bash
   git clone https://github.com/SaberZermani/sales_payment_utility.git
   cd sales_payment_utility

2. Install dependencies using Composer:
    composer install

3. Generate sales payment dates using the Symfony console command:

    symfony console app:generate-sales-payments [output_file]

        Note :
        Replace [output_file] with the desired path for the output CSV file. If the file already exists, the utility will ask if you want to append the missing months. If the file doesn't exist, the utility will create it in the same Path and add all the monthly payment dates.

## Vesion

This utility is built using Symfony 6 and requires PHP 8.

## Editor

VS CODE
