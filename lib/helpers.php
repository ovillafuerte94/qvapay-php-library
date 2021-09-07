<?php

namespace Qvapay;

/**
 * Helpers Class.
 *
 * @category Abstract Class
 *
 * @author   Omar Villafuerte
 *
 * @link    https://ovillafuerte94.is-a.dev
 */
abstract class helpers
{
    /**
     * Check if a string is JSON.
     *
     * @param string $string
     *
     * @return bool
     */
    public static function isJson(string $string): bool
    {
        json_decode($string);

        return json_last_error() === JSON_ERROR_NONE;
    }
}
