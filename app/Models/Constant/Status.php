<?php
namespace App\Models\Constant;

class Status extends AbstractConstant
{
    const ACTIVE = 1;
    const INACTIVE = 0;

    public static function getOptions(){

        return [
            self::ACTIVE                        =>  __("Active"),
            self::INACTIVE                      =>  __("Inactive"),
        ];
    }
}
