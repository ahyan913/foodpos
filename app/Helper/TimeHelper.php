<?php
namespace App\Helper;
use App\Models\Timeslot;


class TimeHelper{

    const MONDAY = 1;
    const TUESDAY = 2;
    const WEDNESDAY = 3;
    const THURSDAY = 4;
    const FRIDAY = 5;
    const SATURDAY = 6;
    const SUNDAY = 7;

    public static function getOptions(){
        $options = [];
        for($i = 0; $i<1440 ; $i+=30):
            $h  = (int)($i / 60);
            $m = $i % 60;
            $hh = $h < 10 ? "0$h":$h;
            $mm = $m < 10 ? "0$m":$m;
            $option[]= $hh.":".$mm;
        endfor;
        return $option;
    }

    public static function isAvailable($timeSlot){

        $today = date("Y-m-d");
        $excludedDates = json_decode($timeSlot->exclude_dates) ?? [];

        if(in_array($today, $excludedDates))
            return 1;

        $setting = null;

        switch(date("N")){

            case self::MONDAY:
                $weekday = $timeSlot->monday;
                break;
            case self::TUESDAY:
                $weekday = $timeSlot->tuesday;
                break;
            case self::WEDNESDAY:
                $weekday = $timeSlot->wednesday;
                break;
            case self::THURSDAY:
                $weekday = $timeSlot->thursday;
                break;
            case self::FRIDAY:
                $weekday = $timeSlot->friday;
                break;
            case self::SATURDAY:
                $weekday = $timeSlot->saturday;
                break;
            case self::SUNDAY:
                $weekday = $timeSlot->sunday;
                break;
            default:
                return 2;
        }

        if($setting = json_decode($weekday, true)){
            $now = date("H:i");
            extract($setting);
            if(strtotime($now) < strtotime($start_time))
                return 3;

            if(strtotime($now) > strtotime($end_time))
                return 4;

            if(strtotime($rest_start) <= strtotime($now) && strtotime($now) <= strtotime($rest_end))
                return 5;
        }else{
            return 6;
        }

        return true;

    }
}
