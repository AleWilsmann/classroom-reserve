<?php

namespace App\Models;

<<<<<<< HEAD
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
}
=======
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
>>>>>>> 358b4ef (feature/reservation-api)
