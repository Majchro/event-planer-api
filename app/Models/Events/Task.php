<?php

declare(strict_types=1);

namespace App\Models\Events;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'date',
        'finished_at',
        'user_id',
        'organization_id',
    ];

    protected $casts = [
        'date' => 'datetime:Y-m-d\TH:i:sP',
        'finished_at' => 'datetime:Y-m-d\TH:i:sP',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}
