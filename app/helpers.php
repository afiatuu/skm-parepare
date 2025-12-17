<?php

if (!function_exists('cleanLabel')) {
    function cleanLabel($text) {
        return preg_replace('/\s*\(.*?\)/', '', $text);
    }
}