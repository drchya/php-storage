<?php

date_default_timezone_set('Asia/Jakarta');

define('BASE_URL', '/php-crud/');
define('COMPONENT_PATH', __DIR__ . '/../Views/Component/');

spl_autoload_register(function ($class) {
    $paths = ['Controllers/', 'Models/'];
    foreach ($paths as $path) {
        $file = __DIR__ . '/../' . $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});
