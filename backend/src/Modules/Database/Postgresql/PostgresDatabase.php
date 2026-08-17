<?php


namespace App\Modules\Database\Postgresql;

use App\Modules\Database\Contracts\IDatabase;
use App\Modules\Logger\Contracts\ILogger;
use PDO;
use PDOException;
use RuntimeException;

class PostgresDatabase implements IDatabase
{

    private const MAX_TRIES = 5;
    private const RETRY_DELAY = 5;

    private ILogger $logger;
    private array $config;

    private ?PDO $pdo = null;


    public function __construct(ILogger $logger, array $config)
    {
        $this->logger = $logger;

        if ($this->validateConnectionConfig($config)) {
            $this->config = $config;
        } else {
            throw new RuntimeException("Incorrect database configuration");
        }
    }

    private function connect() {
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ];

        $attempts = self::MAX_TRIES;
        while (!isset($this->pdo)) {
            $attempts--;
            try {
                $this->pdo = new PDO("pgsql:
                    host={$this->config['host']};
                    port={$this->config['port']};
                    dbname={$this->config['dbname']};",
                $this->config['user'], $this->config['password'], $options);
            } catch (PDOException $e) {

                if ($attempts == 0)
                    throw new RuntimeException("Error while connecting to the Postgresql database: " . $e->getMessage());

                $this->logger->warning("Failed connect to Postgresql database. Retrying after " . self::RETRY_DELAY . "s...");
                sleep(self::RETRY_DELAY);
            }
        }
    }

    public function transaction(callable $fn)
    {
        //TODO
    }

    public function getConnection(): PDO
    {
        if ($this->pdo == null)
            $this->connect();
        return $this->pdo;
    }

    private function validateConnectionConfig(array $config): bool {
        return isset($config['host']) && is_string($config['host']) &&
            isset($config['port']) && is_int($config['port']) &&
            isset($config['dbname']) && is_string($config['dbname']) &&
            isset($config['user']) && is_string($config['user']) &&
            isset($config['password']) && is_string($config['password']);
    }
}
