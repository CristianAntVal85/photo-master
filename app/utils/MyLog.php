<?php

namespace dwes\app\utils;

use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;

class MyLog
{
    /**
     * @var Logger
     */
    private $log;

    private function __construct(string $filename)
    {
        $this->log = new Logger('name');
        $this->log->pushHandler(new StreamHandler($filename, Level::Info));
    }

    public static function load(string $filename): MyLog
    {
        return new MyLog($filename);
    }

    public function add(string $message): void
    {
        $this->log->info($message);
    }
}
