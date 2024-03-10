<?php

define('APP_DEBUG', true);
define('APP_LANG', 'en');
define('APP_TIMEZONE', 'America/Mexico_City');
define('APP_NAME', 'PHRONT');
define('APP_URL', 'http://localhost:8000');
define('APP_LANG_SUPPORTED', [ 'en', 'es' ]);
define('APP_LANG_DEFAULT', 'en');
define('ASSET_URL', 'http://localhost:5173');
define('STATIC_URL', APP_URL.'/static');

define('SESSION_FIELD', 'phront');

define('BASE_PATH', __DIR__ . '/..');
define('SRC_PATH', __DIR__);

define('PUBLIC_PATH', BASE_PATH.'/public');
define('STORAGE_PATH', BASE_PATH.'/storage');

define('PAGE_PATH', SRC_PATH.'/pages');
define('FUNC_PATH', SRC_PATH.'/functions');
define('DB_PATH', STORAGE_PATH.'/database');
define('CACHE_PATH', STORAGE_PATH.'/cache');

define('ERR_PAGE_PATH', SRC_PATH.'/errors');
define('LAYOUT_PATH', SRC_PATH.'/layouts');
define('PARTIAL_PATH', SRC_PATH.'/partials');

define('RESOURCE_PATH', SRC_PATH.'/resources');
define('LANG_PATH', RESOURCE_PATH.'/lang');

define('STATIC_PATH', PUBLIC_PATH.'/static');
define('VITE_MANIFEST', STATIC_PATH.'/.vite/manifest.json');
define('COMPOSER_AUTOLOADER', BASE_PATH.'/vendor/autoload.php');

define('VALIDATION_PATH', SRC_PATH.'/validations');
define('TABLE_PATH', SRC_PATH.'/tables');

define('HTTP_OK', 200);
define('HTTP_CREATED', 201);
define('HTTP_ACCEPTED', 202);
define('HTTP_NO_CONTENT', 204);
define('HTTP_REDIRECT_PERMANENTLY', 301);
define('HTTP_REDIRECT', 303);
define('HTTP_BAD_REQUEST', 400);
define('HTTP_UNAUTHORIZED', 401);
define('HTTP_FORBIDDEN', 403);
define('HTTP_NOT_FOUND', 404);
define('HTTP_METHOD_NOT_ALLOWED', 405);
define('HTTP_NOT_ACCEPTABLE', 406);
define('HTTP_INTERNAL_SERVER_ERROR', 500);
define('HTTP_NOT_IMPLEMENTED', 501);

define('SQLITE_PATH', DB_PATH.'/db.sqlite');

define('MYSQL_HOST', 'localhost');
define('MYSQL_PORT', '3306');
define('MYSQL_NAME', 'phront');
define('MYSQL_USER', 'root');
define('MYSQL_PASSWD', '');

