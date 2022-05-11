<?php

foreach (scandir(__DIR__) as $file) {
    // Require .php files only
    if ('_autoloader.php' != $file && substr($file, -4, 4) == '.php') {
        include __DIR__.'/'.$file;
    }
}
