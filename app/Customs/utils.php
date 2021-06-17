<?php

namespace App\Customs;

use Illuminate\Support\Facades\Auth;

class Utils
{
    /**
    *  take an array and append the authenticated user model
    *
    *  @return void
    *  @param array $data array of things that need to be pass to the view
    */
    public static function userAuth($data){
        if (Auth::check()) {
            $user = Auth::user();
            $data['user'] = $user;
        }

        return $data;
    }

    public static function test($var)
    {
        return $var += 20;
    }

    public static function GetURI(){

    }

    public static function stringShortener(string $sentance, int $lenght)
    {
        if (strlen($sentance) > $lenght) {
            return substr($sentance, 0, $lenght)."...";
        }
        else {
            return $sentance;
        }
    }
}
