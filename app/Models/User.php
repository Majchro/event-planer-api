<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Events\Task;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean',
    ];

    public function organizations(): BelongsToMany
    {
        return $this->belongsToMany(Organization::class)
            ->withPivot('role');
    }

    public function defaultOrganization(): Organization
    {
        $session_organization_id = session()->get('organization_id');
        if (is_null($session_organization_id)) {
            return $this->organizations()
                ->first();
        }

        return $this->organizations()
            ->find($session_organization_id);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
