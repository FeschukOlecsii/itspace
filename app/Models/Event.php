<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'title',
        'color',
        'date_time_start',
        'date_time_end', 
        'completed'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
