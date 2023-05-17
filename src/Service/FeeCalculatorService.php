<?php

namespace PragmaGoTech\Interview\Service;

use InvalidArgumentException;
use PragmaGoTech\Interview\FeeCalculator;
use PragmaGoTech\Interview\Model\LoanProposal;

class FeeCalculatorService implements FeeCalculator
{
    private array $feeStructure;

    public function __construct(
        array $feeStructure
    )
    {
        $this->feeStructure = $feeStructure;
    }

    public function calculate(LoanProposal $application): float
    {
        $amount = $application->amount();
        $lowerBound = 1000;
        $upperBound = 20000;

        if ($amount < $lowerBound || $amount > $upperBound) {
            throw new InvalidArgumentException("Incorrect loan value, the value should be between 1000 and 20000 PLN");
        }

        foreach ($this->feeStructure as $breakpoint => $fee) {
            if ($breakpoint <= $amount && $breakpoint > $lowerBound) {
                $lowerBound = $breakpoint;
            } elseif ($breakpoint >= $amount && $breakpoint < $upperBound) {
                $upperBound = $breakpoint;
            }
        }

        $lowerFee = $this->feeStructure[$lowerBound];
        $upperFee = $this->feeStructure[$upperBound];

        $feeInterpolated = $lowerFee + (($upperFee - $lowerFee) / ($upperBound - $lowerBound)) * ($amount - $lowerBound);

        $result = ceil(($feeInterpolated + $amount) / 5) * 5;
        return $result - $amount;
    }
}