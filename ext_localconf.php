<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

$GLOBALS['TYPO3_CONF_VARS']['SYS']['productionExceptionHandler'] = \Susanne\Bluescreen\Error\ProductionExceptionHandler::class;
