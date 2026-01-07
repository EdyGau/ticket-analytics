<?php

declare(strict_types=1);

namespace App\Tests\Application\Service;

use App\Domain\Service\FinancialConfig;
use PHPUnit\Framework\TestCase;

class ImportMathTest extends TestCase
{
    /**
     * Verifies that the commission logic correctly chooses between
     * percentage and flat rate floor.
     */
    public function testCooperationCostLogic(): void
    {
        $tickets = 1000;
        $revenue = $tickets * FinancialConfig::AVG_TICKET_PRICE;

        $commByRate = $revenue * FinancialConfig::COMMISSION_RATE;
        $commByMin = $tickets * FinancialConfig::MIN_COMMISSION_PER_TICKET;

        $finalComm = max($commByRate, $commByMin);

        $this->assertEquals(1750.0, $finalComm);
        $this->assertEquals(9750.0, FinancialConfig::MONTHLY_SUBSCRIPTION_FEE + $finalComm);
    }

    /**
     * Validates the 12-month revenue target defined in the recruitment task.
     */
    public function testTwelveMonthRevenueTarget(): void
    {
        $totalVolume = 56250;
        $this->assertEquals(3937500.0, $totalVolume * FinancialConfig::AVG_TICKET_PRICE);
    }
}
