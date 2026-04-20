<?php

namespace App\Services;

class PhoneService
{
    public static function normalize($phone)
    {
        // remove spaces, dashes, brackets
        $phone = preg_replace('/[^0-9+]/', '', $phone);

        // ensure starts with +
        if (!str_starts_with($phone, '+')) {
            $phone = '+' . $phone;
        }

        return $phone;
    }
}