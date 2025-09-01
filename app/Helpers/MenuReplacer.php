<?php

use Illuminate\Support\Facades\Session;

if (! function_exists('replaceSessionPlaceholders')) {
    /**
     * Ganti placeholder {key} pada string dengan value dari session
     *
     * @param string $path
     * @return string
     */
    function replaceSessionPlaceholders(string $path): string
    {
        return preg_replace_callback('/\{([^}]+)\}/', function ($matches) {
            $key = $matches[1];
            return Session::has($key) ? Session::get($key) : $matches[0];
        }, $path);
    }
}
