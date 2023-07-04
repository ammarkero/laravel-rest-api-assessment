<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    const ADMIN = 1;
    const USER = 2;
    const GUEST = 3;

    protected $table = 'roles';

    protected $fillable = [
        'user_id',
        'role_id'
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'role_user', 'role_id', 'user_id');
    }
}
