<?php

namespace App\Helpers;

class StringHelper
{
    public static function isValidName($authorName): bool
    {
        if (empty(trim($authorName))) {
            return false;
        }

        $authorNameRegex = "/^[A-Za-z\s\-'&]+$/";
        return preg_match($authorNameRegex, $authorName) === 1;
    }
    
}
