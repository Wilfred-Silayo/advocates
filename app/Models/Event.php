<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'content', 'date_time', 'images'];

    protected $casts = [
        'images' => 'array',
        'date_time' => 'datetime',
    ];


    public function getDateTimeFormattedAttribute()
    {
        return $this->date_time->format('d M Y, h:i A');
    }
}
