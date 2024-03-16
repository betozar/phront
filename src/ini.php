<?php

/**
 * ================================
 * Initialization
 * ================================
 */

declare(strict_types=1);

session_start();

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/helpers.php';
require_once COMPOSER_AUTOLOADER;

error_reporting(
	APP_DEBUG
	? E_ALL
	: 0
);

date_default_timezone_set(APP_TIMEZONE);

session_flash_start();
session_lang_start();

$page = router_get_page();

if( is_null($page) ) {
	http_throw_not_found(false);
} else {
	require_page($page);
}

session_flash_end();

exit;
