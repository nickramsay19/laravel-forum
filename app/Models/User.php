<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'bot_settings' => 'array',
        ];
    }

    // utilities

    public function viewablePosts() {
        return Post::whereNotNull('published_at')
            ->orWhere('author_id', $this->id);
    }

    // relations

    public function posts() {
        return $this->hasMany(Post::class, 'author_id');
    }

    public function roles() {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    public function permissions() {
        return Permission::query()
            ->join('role_permissions', 'permissions.id', '=', 'role_permissions.permission_id')
            ->join('user_role', 'role_permissions.role_id', '=', 'user_role.role_id')
            ->where('user_role.user_id', $this->id)
            ->distinct();
    }
}
