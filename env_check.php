<?php

$exists = file_exists(__DIR__ . '/.env');

if (!$exists) {
    copy(
        __DIR__ . '/.env.example',
        __DIR__ . '/.env'
    );
    exec('php artisan key:generate');
}
