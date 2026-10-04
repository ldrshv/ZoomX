<?php

if (PHP_SAPI !== 'cli') {
    return;
}

require __DIR__.'/config.core.php';
// MODX 3: bootstrap via composer autoloader, modX is namespaced now
require_once MODX_CORE_PATH . 'vendor/autoload.php';
$modx = new \MODX\Revolution\modX();
$modx->initialize('mgr');
$modx->getService('error', \MODX\Revolution\Error\modError::class, '', '');

$result = Zoomx\Commands\CommandManager::execute(array_slice($argv, 1));
print_r($result);
