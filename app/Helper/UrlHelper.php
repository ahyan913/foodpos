<?php
namespace App\Helper;

class UrlHelper{

    public static function admin($path = "")
    {
        return url(implode("/", [self::adminUri(), $path]));
    }

    public static function adminUri(){
        return config("app.admin_uri");
    }
}
