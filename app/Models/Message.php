<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message',
    ];

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    protected function message(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => strtolower(strip_tags($value)),
            get: fn ($value) => str()->title($value)
        );
    }

    #[Scope]
    protected function messageReceiver(Builder $query, $receiverId)
    {
        return $query->where('receiver_id', $receiverId)
                ->where('sender_id', Auth::user()->id);
    }

    #[Scope]
    protected function messageSender(Builder $query, $senderId)
    {
        return $query->orWhere('sender_id', $senderId)
                ->where('receiver_id', Auth::user()->id);
    }
}
