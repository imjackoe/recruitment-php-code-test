<?php

namespace App\Service\Logger;

interface LoggerInterface
{

    public function info($message = '');

    public function debug($message = '');

    public function error($message = '');

}