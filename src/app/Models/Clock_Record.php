<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clock_Record extends Model
{
    use HasFactory;

    protected $table = 'clock_records';

    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'user_id',
        'checkin_time',
        'checkout_time',
        'date'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function breaktimes()
    {
        return $this->hasMany(Breaktime::class, 'clock_record_id');
    }

}
