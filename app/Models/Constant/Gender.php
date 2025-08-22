<?php
namespace App\Models\Constant;

class Gender extends AbstractConstant
{
    const MALE = 1;
    const FEMALE = 2;
    const NONDISCLOSURE = 3;

    public static function getOptions(){

        return [
            self::MALE => __("Male"),
            self::FEMALE => __("Female"),
            self::NONDISCLOSURE => __("Not Specified")
        ];
    }

    public static function get($status){
        $options = self::getOptions();
        return $options[$status] ?? "";
    }

}
