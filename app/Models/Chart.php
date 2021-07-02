<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chart extends Model
{
    use HasFactory;

    protected $fillable = [
        'chart_type',
        'name_dataset',
        'value_dataset',
        'x_axis',
        'y_axis',
    ];
}
