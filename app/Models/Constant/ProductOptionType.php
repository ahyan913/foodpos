<?php

namespace App\Models\Constant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOptionType extends AbstractConstant
{
    use HasFactory;

    const TEXT = 1;
    const SINGLE_OPTION = 2;
    const MULTIPLE_OPTIONS = 3;

    public static function getOptions(){
        return [
            self::TEXT => __("Text"),
            self::SINGLE_OPTION => __("Single Option"),
            self::MULTIPLE_OPTIONS => __("Multiple Options"),
        ];
    }
}
