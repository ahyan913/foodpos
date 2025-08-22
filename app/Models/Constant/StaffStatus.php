<?php
namespace App\Models\Constant;

class StaffStatus extends Status
{
    const PENDING_EMAIL_VERIFICATION = 3;

    public static function getOptions(){

        return array_merge(
            parent::getOptions(),
            [
                self::PENDING_EMAIL_VERIFICATION    =>  __("Pending Email Verification")
            ]
        );
    }
}
