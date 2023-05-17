<?php


use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use PragmaGoTech\Interview\Model\LoanProposal;
use PragmaGoTech\Interview\Service\FeeCalculatorService;

class FeeCalculatorTest extends TestCase
{
    private static ?array $feeStructure;
    private static ?FeeCalculatorService $feeCalculatorService;
    private static ?LoanProposal $incorrectAmountAbove;
    private static ?LoanProposal $incorrectAmountBelow;

    final public static function setUpBeforeClass(): void
    {
        self::$feeStructure = [
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

        self::$feeCalculatorService = new FeeCalculatorService(self::$feeStructure);

        self::$incorrectAmountAbove = new LoanProposal(25000);
        self::$incorrectAmountBelow = new LoanProposal(50);
    }

    #[DataProvider('amountsProvider')]
    public function testCalculate(LoanProposal $application): void
    {
        $fee = self::$feeCalculatorService->calculate($application);

        $this->assertEquals(0, ($application->amount() + $fee) % 5);
        $this->assertGreaterThan(0, $fee);
        $this->assertLessThan($application->amount(), $fee);
    }

    public function testExceptionAbove(): void
    {
        $this->expectException(InvalidArgumentException::class);
        self::$feeCalculatorService->calculate(self::$incorrectAmountAbove);
    }

    public function testExceptionBelow(): void
    {
        $this->expectException(InvalidArgumentException::class);
        self::$feeCalculatorService->calculate(self::$incorrectAmountBelow);
    }

    public static function amountsProvider(): array
    {
        return [
            [new LoanProposal(6500)],
            [new LoanProposal(19250)],
            [new LoanProposal(7354)],
            [new LoanProposal(2222)],
            [new LoanProposal(5495)],
            [new LoanProposal(2054)],
            [new LoanProposal(2591)],
            [new LoanProposal(6405)]
        ];
    }

}
