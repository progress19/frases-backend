<?php

namespace App\Helpers;

class Helpers
{
    public static function obtenerNumeros($string)
    {
        return preg_replace('/[^0-9]/', '', $string);
    }

}
