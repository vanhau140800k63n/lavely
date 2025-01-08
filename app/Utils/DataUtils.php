<?php

namespace App\Utils;

class DataUtils
{
    public static function getBodyHtml($html)
    {
        preg_match('/<body class="position-relative">(.*?)<\/body>/', $html, $matches);
        return $matches;
    }
}
