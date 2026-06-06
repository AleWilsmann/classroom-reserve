<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    protected $fillable = [
        'user_id',
        'classroom',
        'date',
        'start_time',
        'end_time',
        'purpose',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'date'       => 'date',
            'start_time' => 'string',
            'end_time'   => 'string',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Verifica se há conflito de horário para uma sala e data.
     */
    public static function hasConflict(string $classroom, string $date, string $start, string $end, ?int $excludeId = null): bool
    {
        return self::where('classroom', $classroom)
            ->where('date', $date)
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