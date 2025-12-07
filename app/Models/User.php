<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'phone',
        'role',
        'image',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getRouteKeyName()
    {
        return 'username';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isNotPrincipal()
    {
        return $this->role !== 'kepala_sekolah';
    }

    public function getAvatarUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : asset('assets/images/profile/user-1.jpg');
    }

    public function getStatusColorAttribute()
    {
        return $this->status == 'active' ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-muted';
    }

    public function transferIns()
    {
        return $this->hasMany(TransferIn::class);
    }

    public function transferOuts()
    {
        return $this->hasMany(TransferOut::class);
    }

    public function activeTeachings()
    {
        return $this->hasMany(ActiveTeaching::class);
    }
}
