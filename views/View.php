<?php
namespace trimination;
class View {
    public function __construct($name, $data = null) {
        header("Content-Type: text/html; charset=utf-8");
        if($data) extract($data);
        ob_start();
        require_once __DIR__ . '/templates/header.php';
        if(!file_exists(__DIR__ . '/templates/' . $name . '.php')) {
            require_once __DIR__ . "/templates/404.php";
        } else {
            require_once __DIR__ . "/templates/$name.php";
        }
        require_once __DIR__ . '/templates/footer.php';
        echo ob_get_clean();
    }
}