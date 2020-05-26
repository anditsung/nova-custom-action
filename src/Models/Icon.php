<?php


namespace Tsung\NovaCustomAction\Models;


use Illuminate\Database\Eloquent\Model;

class Icon extends Model
{
    protected $fillable = [
        'name',
        'width',
        'height',
        'icon',
        'class',
    ];
}
