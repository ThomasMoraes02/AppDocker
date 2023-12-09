<?php 
namespace App\Infra\Logging;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class MonologLogging implements Logging
{
    private readonly Logger $logger;

    public function __construct()
    {
        if(!is_dir(__DIR__ . '/../../../storage/logs')) {
            mkdir(__DIR__ . '/../../../storage/logs', 777, true);

            if(!file_exists(__DIR__ . '/../../../storage/logs/app.log')) {
                touch(__DIR__ . '/../../../storage/logs/app.log');
            }
        }

        $this->logger = new Logger('app');
        $this->logger->pushHandler(new StreamHandler(__DIR__ . "/../../../storage/logs/app.log"));
    }

    public function info(string $message, array $context = []): void
    {
        $this->logger->info($message, $context);
    }

    public function warning(string $message, array $context = []): void
    {
        $this->logger->info($message, $context);
    }

    public function error(string $message, array $context = []): void
    {
        $this->logger->info($message, $context);
    }
}