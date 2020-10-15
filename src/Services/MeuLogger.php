<?php

namespace App\Services;

use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Mero\Monolog\Handler\TelegramHandler;

class MeuLogger
{
    public function log($data) {
	$log = new Logger('Hibrido');
	$log->pushHandler(new RotatingFileHandler(LOG_DIR.'HibridoLog.log'));

	//$log->debug('DEBUG');
	//$log->info('INFO');
	
	return $log->info($data);;
    }
}
