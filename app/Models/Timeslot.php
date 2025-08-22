<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timeslot extends Model
{
    use HasFactory;

    public $table = "timeslot";
    public $fillable = ["monday","tuesday","wednesday","thursday","friday","saturday","sunday","exckude_date"];

}
