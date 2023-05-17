<?php

require __DIR__ . '/vendor/autoload.php';

use PragmaGoTech\Interview\Model\LoanProposal;
use PragmaGoTech\Interview\Service\FeeCalculatorService;

$feeStructure = [
    1000 => 50,
    2000 => 90,
    3000 => 90,
    4000 => 115,
    5000 => 100,
    6000 => 120,
    7000 => 140,
    8000 => 160,
    9000 => 180,
    10000 => 200,
    11000 => 220,
    12000 => 240,
    13000 => 260,
    14000 => 280,
    15000 => 300,
    16000 => 320,
    17000 => 340,
    18000 => 360,
    19000 => 380,
    20000 => 400,
];

$calculator = new FeeCalculatorService($feeStructure);

$amount = 7549;

$application = new LoanProposal($amount);
$fee = $calculator->calculate($application);

echo 'fee: '. $fee . ' amount: ' . $amount . ' total: ' . ($fee + $amount);