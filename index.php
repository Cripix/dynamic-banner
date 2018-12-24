<?php

    use Tivet\Banner\App;

    require_once __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

    try {
        new App();
    }
    catch (Exception $e) {
        echo $e->getMessage();
    }