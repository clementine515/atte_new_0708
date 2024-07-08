<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Breaktime extends Model
{
    use HasFactory;

    protected $table = 'breaks';

    protected $guarded = [
        'id',
    ];

    protected $fillable = ['clock_record_id', 'start_time', 'end_time'];

    public function clock_record(){
        return $this->belongsTo(Clock_Record::class);
    }
}
