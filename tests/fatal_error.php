<?php

namespace PHPPoint\HowToRegisterAndTestShutdownFunctions;

require_once __DIR__.'/../vendor/autoload.php';

$resource = new TemporaryFileResource('%s');

trigger_error('Fatal error!', E_USER_ERROR);
