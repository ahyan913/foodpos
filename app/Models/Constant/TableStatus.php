<?php

namespace App\Models\Constant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableStatus extends Status
{
    const READY_FOR_BILL = 2;

    public static function getOptions(){

        return array_merge(parent::getOptions(), [
            self::READY_FOR_BILL                =>  __("Ready for bill")
        ]);
    }
}
