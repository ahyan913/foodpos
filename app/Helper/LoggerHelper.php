<?php
namespace App\Helper;
use Illuminate\Support\Facades\Log;
use App\Models\Configuration;

class LoggerHelper
{
    public static function debug($message, $context = []){
        if(Configuration::findByKey("debug_log")){
            $trace = debug_backtrace();
            $class = $trace[1]['class'];
            $func = $trace[1]['function'];
            $lineNo = $trace[0]['line'];
            Log::debug("[$class::$func (Line $lineNo)] - ".$message, $context);
        }
    }

    public function error($msg, $context = []){

        $trace = debug_backtrace();
        $class = $trace[1]['class'];
        $func = $trace[1]['function'];
        Log::error("[$class:$func] - $msg", $context);
    }

}
