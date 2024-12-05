<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation',
        'room_id',
        'start',
        'end',
        'description',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
