<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalAct extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'name',
        'description',
        'tarif',
        'user_id',

    ];
}
