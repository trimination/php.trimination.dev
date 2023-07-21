<?php
if ($handle = opendir('./models/')) {
    while (false !== ($entry = readdir($handle))) {
        if (trimination\Helper::str_contains(".php", $entry) && $entry != "index.php") {
            require_once './models/' . $entry;
        }
    }
    closedir($handle);
}