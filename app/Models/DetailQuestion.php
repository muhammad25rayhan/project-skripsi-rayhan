<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailQuestion extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'question_id',
        'question',
        'image',
        'choice_1',
        'weight_1',
        'choice_2',
        'weight_2',
        'choice_3',
        'weight_3',
        'choice_4',
        'weight_4',
        'choice_5',
        'weight_5',
        'key'
    ];
}
