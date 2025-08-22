<?php
namespace App\Helper;

class LocaleHelper{

    public static function getValue($storeLocale, $locale, $key)
    {


        $localeData = isset($storeLocale[$locale][$key]) ? $storeLocale[$locale][$key]:null;

        if(is_array($localeData)){
            var_dump($localeData);
            return "";
        }

        return $localeData;
    }
}
