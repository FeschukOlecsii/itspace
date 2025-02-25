<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Reminder extends Model
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
        'date_time',
        'recurrence',
        'recurrence_days',
        'recurrence_day_of_month',
        'recurrence_day_of_year',
        'completed'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
