<?php

namespace App\Service;

use Psr\Log\LoggerInterface;

class LogService
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function logInfo(string $message): void
    {
        $this->logger->info($message);
    }

    public function logError(string $message): void
    {
        $this->logger->error($message);
    }

    // Autres méthodes de log selon les besoins (warning, debug, etc.)
}
