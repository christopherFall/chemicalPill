<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $fillable = ['name', 'type', 'subtype', 'side_effects']; //Protección de asignación masiva
}
