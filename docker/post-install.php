<?php

use app\lib\Install;
use uhi67\umvc\AppHelper;

require_once dirname(__DIR__).'/vendor/autoload.php';
try {
    Install::postInstall();
} catch (Exception $e) {
    AppHelper::showException($e);
}
