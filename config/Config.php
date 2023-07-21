<?php
$protocolPrefix = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https://' : 'http://';
define('BASE_DIR', str_replace('/config', '', __DIR__));
define('PROJECT_DIR', ''); //relative to root
define('BASE_URL', $protocolPrefix . $_SERVER['SERVER_NAME'] . '/' . PROJECT_DIR);
define('SITE_NAME', '');
define('DB_USER', "");
define('DB_PASS', "");
define('DB_HOST', "");
define('DB_NAME', "");