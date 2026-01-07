<?php

declare(strict_types=1);

namespace App\Domain\Service;

/**
 * Global financial business rules for revenue modeling.
 */
final class FinancialConfig
{
    public const AVG_TICKET_PRICE = 70.0;
    public const MONTHLY_SUBSCRIPTION_FEE = 8000.0;
    public const COMMISSION_RATE = 0.025;
    public const MIN_COMMISSION_PER_TICKET = 1.1;
}
