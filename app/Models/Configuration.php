<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Configuration extends Model
{
    use HasFactory;

    protected $table = "configurations";
    protected $primaryKey = "id";

    public function getValue(){

        $value = $this->value;

        if($jsonDecodedValue = json_decode($value)){
            return $jsonDecodedValue;
        }

        try{
            if($unserializedValue = unserialize($value)){
                return $unserializedValue;
            }
        }catch(\Throwable $t){
            //Log::error(__CLASS__.":".__FUNCTION__.":".$t);
        }

        return $value;
    }

    public static function findByKey($key){
        $row = self::where("path",$key)->first();
        return  $row ? $row->getValue():null;
    }
}
