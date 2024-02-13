<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        "full_name",
        "email",
        "country",
        "city",
        "address",
        "gender_id",
        "user_id",
        "company_id",
        "position_id",
        "super_visor_id",
    ];
}
