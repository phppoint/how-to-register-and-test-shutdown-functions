<?php

namespace PHPPoint\HowToRegisterAndTestShutdownFunctions;

require_once __DIR__.'/../vendor/autoload.php';

$resource = new TemporaryFileResource($_SERVER['TEMP_FILE']);

trigger_error('Fatal error!', E_USER_ERROR);
