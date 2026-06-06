<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'room_id',
        'responsible_id',
        'start_time',
        'end_time',
        'description',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'user_id'        => 'integer',
            'room_id'        => 'integer',
            'responsible_id' => 'integer',
            'start_time'     => 'datetime',
            'end_time'       => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function responsible(): BelongsTo
    {
        return $this->belongsTo(Responsible::class);
    }

    public static function hasConflict(
        int $roomId,
        string $start,
        string $end,
        ?int $excludeId = null
    ): bool {
        return self::where('room_id', $roomId)
            ->whereIn('status', ['pending', 'confirmed'])
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