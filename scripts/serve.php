<?php

require_once __DIR__ . '/../src/config.php';

$server = str_replace('http://', '', APP_URL);

system("php -S $server -t public");
