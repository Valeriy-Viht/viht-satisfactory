<?php


namespace App\Modules\Logger;

use App\Modules\Logger\Contracts\ILogger;
use JsonException;
use Psr\Log\LogLevel;

class ConsoleLogger implements ILogger {

    private string $channel;
    private string $stream;

    public function __construct(string $channel = "APP", string $stream = "php://stdout")
    {
        $this->channel = $channel;
        $this->stream = $stream;
    }

    public function log(string $message, string $level = "INFO", $context = []) {

        try {
            $contextStr = empty($context) ? "" : json_encode($context, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            $this->warning("JSON encode error: " . $e->getMessage() . " .Log without context.");
            $contextStr = "(context encode error)";
        }
        $timestamp = date("Y-m-d H:m:s");

        $formated = sprintf(
            "[%s] [%s] [%s] %s %s\n",
            $timestamp,
            strtoupper($level),
            $this->channel,
            $message,
            $contextStr
        );


        $fs = fopen($this->stream, 'a');
        fwrite($fs, $formated);
        fclose($fs);
    }

    public function info(string $message, array $context = []) {
        $this->log($message, LogLevel::INFO, $context);
    }

    public function error(string $message, array $context = []) {
        $this->log($message, LogLevel::ERROR, $context);
    }

    public function warning(string $message, array $context = []) {
        $this->log($message, LogLevel::WARNING, $context);
    }

    public function debug(string $message, array $context = []) {
        $this->log($message, LogLevel::DEBUG, $context);
    }

}