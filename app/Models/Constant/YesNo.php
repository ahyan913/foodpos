<?php
namespace App\Models\Constant;

class YesNo extends AbstractConstant
{
    const YES = 1;
    const NO = 0;


    public static function getOptions()
    {
        return [
            self::YES   =>  __("Yes"),
            self::NO    =>  __("No")
        ];
    }


}
