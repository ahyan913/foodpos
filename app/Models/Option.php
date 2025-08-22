<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OptionGroup;

class Option extends Model
{
    use HasFactory;

    protected $table = "options";
    protected $casts = ["locale"=>"array"];
    protected $fillable = [""];

    public function groups(){
        return $this->belongsTo(OptionGroup::class, 'option_group_id',"id");
    }
}
