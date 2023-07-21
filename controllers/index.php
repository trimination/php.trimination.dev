<?php
if ($handle = opendir('./controllers/')) {
    while (false !== ($entry = readdir($handle))) {
        if (trimination\Helper::str_contains(".php", $entry) && $entry != "index.php") {
            require_once './controllers/' . $entry;
        }
    }
    closedir($handle);
}