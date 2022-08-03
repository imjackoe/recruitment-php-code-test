<?php

namespace App\Service;

interface ILogger
{
    public function info(string $message);

    public function debug(string $message);

    public function error(string $message);
}
