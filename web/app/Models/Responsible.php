<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Responsible extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'department',
        'description',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
