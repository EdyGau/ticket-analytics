<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Domain\Enum\Month;
use App\Domain\Service\FinancialConfig;
use App\Exception\InvalidAnalyticsDataException;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Service responsible for orchestrating the Excel data import process.
 * It transforms raw spreadsheet rows into normalized financial data collections.
 */
final class TicketAnalyticsImportService
{
    /**
     * @return array<int, array<string, mixed>>
     *
     * @throws InvalidAnalyticsDataException
     */
    public function importToCollection(UploadedFile $file): array
    {
        try {
            $spreadsheet = IOFactory::load($file->getPathname());
            $rows = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        } catch (\Exception $e) {
            throw new InvalidAnalyticsDataException('The Excel file is unreadable or corrupted.');
        }

        $collection = [];
        foreach ($rows as $row) {
            if ($res1 = $this->parseRow($row['A'] ?? null, $row['B'] ?? null, $row['C'] ?? null, $row['D'] ?? null)) {
                $collection[] = $res1;
            }
            if ($res2 = $this->parseRow($row['E'] ?? null, $row['F'] ?? null, $row['G'] ?? null, $row['H'] ?? null)) {
                $collection[] = $res2;
            }
        }

        if (empty($collection)) {
            throw new InvalidAnalyticsDataException('No valid financial records detected in the provided sheet.');
        }

        return $collection;
    }

    private function parseRow(mixed $year, mixed $monthName, mixed $on, mixed $tot): ?array
    {
        $month = Month::fromPolishName((string) $monthName);
        if (!$month || !is_numeric($year)) {
            return null;
        }

        $online = (int) preg_replace('/[^0-9]/', '', (string) $on);
        $total = (int) preg_replace('/[^0-9]/', '', (string) $tot);

        if ($total <= 0) {
            return null;
        }

        $revenue = $total * FinancialConfig::AVG_TICKET_PRICE;
        $onlineRevenue = $online * FinancialConfig::AVG_TICKET_PRICE;

        $commission = max($onlineRevenue * FinancialConfig::COMMISSION_RATE, $online * FinancialConfig::MIN_COMMISSION_PER_TICKET);

        return [
            'month' => $year.'-'.$month->value,
            'onlineTickets' => $online,
            'totalTickets' => $total,
            'revenue' => $revenue,
            'onlineRevenue' => $onlineRevenue,
            'droplabsCost' => FinancialConfig::MONTHLY_SUBSCRIPTION_FEE + $commission,
        ];
    }
}
