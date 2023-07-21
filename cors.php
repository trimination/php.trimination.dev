<?php

namespace trimination;

function cors() {
    $allowed = [];
    $allowedStr = implode(',', $allowed);
    if ((isset($_SERVER['HTTP_ORIGIN']) && in_array($_SERVER['HTTP_ORIGIN'], $allowed)) || !isset($_SERVER['HTTP_ORIGIN'])) {
        $origin = $_SERVER['HTTP_ORIGIN'] ?? 'http://example.com'; //same domain requests may have no origin
        header("Access-Control-Allow-Origin: {$origin}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');
    } else {
        new Endpoint('403');
        exit();
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        header("Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization");
    }
}
