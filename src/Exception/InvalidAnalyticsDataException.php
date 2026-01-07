<?php

declare(strict_types=1);

namespace App\Exception;

/**
 * Thrown when the provided Excel stream does not match the required financial schema.
 */
final class InvalidAnalyticsDataException extends \DomainException
{
}
