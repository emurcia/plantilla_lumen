<?php

namespace App\Logging;

use Monolog\Logger;
use Monolog\Processor\IntrospectionProcessor;

class CustomizeFormatter
{
    public function __invoke($logger)
    {
        foreach ($logger->getHandlers() as $handler) {
            $handler->pushProcessor(new IntrospectionProcessor(Logger::DEBUG, ['Illuminate\\', 'App\\Helpers\\LogHelper']));
        }
    }
}