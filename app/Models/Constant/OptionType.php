<?php

namespace App\Models\Constant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionType extends AbstractConstant
{
    use HasFactory;

    const NORMAL = 1;
    const PRODUCT = 2;

    public static function getOptions(){

        return [
            self::NORMAL    =>  __("Normal Option"),
            self::PRODUCT   =>  __("Product Option")
        ];
    }


}
