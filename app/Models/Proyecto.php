<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['titulo', 'stack', 'estado', 'resumen'])]
class Proyecto extends Model
{
    //
}