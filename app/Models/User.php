<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Post;
use App\Models\Message;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class,'author_id');
    }

    public function sentMessages():HasMany
    {
        return $this->hasMany(Message::class,'sender_id');
    }

    public function receivedMessages():HasMany
    {
        return $this->hasMany(Message::class,'receiver_id');
    }

    #[Scope]
    protected function exceptYourself(Builder $query)
    {
        return $query->where('id', '!=', Auth::user()->id);
    }

}
