<?php
use App\Service\AppLogger;
require_once __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'vendor/autoload.php';

$logger = new AppLogger('think-log');
$logger->info('think-log');

$logger = new AppLogger();
$logger->info('log4php');
