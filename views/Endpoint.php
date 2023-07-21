<?php
namespace trimination;
class Endpoint {
    public function __construct($name, $data = null) {
        header('Content-Type: application/json; charset=utf-8');
        if($data) extract($data);
        ob_start();
        if(!file_exists(__DIR__ . '/endpoints/' . $name . '.php')) {
            echo Helper::return_status_json(400, "Not Found");
        } else {
            require_once __DIR__ . "/endpoints/$name.php";
        }
        echo ob_get_clean();
    }
}