<?php

declare(strict_types=1);

function dotAccessArray(array $data, string $path, $default = null) {
    if (!empty($path)) {
        $keys = preg_split('/[:\.]/', $path);

        foreach ($keys as $key) {
            if (isset($data[$key])) {
                $data = $data[$key];
            } else {
                return $default;
            }
        }
    }

    return $data;
}

function config(string $path, $default = null) {
    $data = require __DIR__ . "/config.php";
    return dotAccessArray($data, $path, $default);
}