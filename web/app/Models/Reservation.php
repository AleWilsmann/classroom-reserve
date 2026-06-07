<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'responsible_id',
        'user_id',
        'title',
        'description',
        'start_time',
        'end_time',
        'status',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function responsible()
    {
        return $this->belongsTo(Responsible::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function hasConflict(int $room_id, string $start, string $end, ?int $excludeId = null): bool
{
    return self::where('room_id', $room_id)
        ->where('status', 'active')
        ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
        ->where(function ($q) use ($start, $end) {
            $q->whereBetween('start_time', [$start, $end])
              ->orWhereBetween('end_time', [$start, $end])
              ->orWhere(function ($q2) use ($start, $end) {
                  $q2->where('start_time', '<=', $start)
                     ->where('end_time', '>=', $end);
              });
        })
        ->exists();
}
}

