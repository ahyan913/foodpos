<?php
namespace App\Models\Constant;

abstract class AbstractConstant{

    abstract public static function getOptions();

    public static function getOption($key){

        $options = static::getOptions();
        return $options[$key] ?? "";

    }

    public static function get($status){
        $options = self::getOptions();
        return $options[$status] ?? "";
    }
}
