<?php

namespace App\Modules\Logger\Contracts;

interface ILogger {
    public function log(string $message, string $level, array $context = []);
    public function info(string $message, array $context = []);
    public function error(string $message, array $context = []);
    public function warning(string $message, array $context = []);
    public function debug(string $message, array $context = []);
}