<?php

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
    $data = require "config.php";
    return dotAccessArray($data, $path, $default);
}