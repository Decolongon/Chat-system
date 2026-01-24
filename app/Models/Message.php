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
        'sender_deleted_at',
        'receiver_deleted_at',
        'deleted_for_everyone_at',
    ];

    protected $casts = [
        'sender_deleted_at' => 'datetime',
        'receiver_deleted_at' => 'datetime',
        'deleted_for_everyone_at' => 'timestamp',
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
    protected function messageAsSender(Builder $query, $receiverId)
    {
        return $query->where('sender_id', Auth::id())
            ->where('receiver_id', $receiverId)
            ->whereNull('sender_deleted_at');
    }

    #[Scope]
    protected function orMessageAsReceiver(Builder $query, $senderId)
    {
        return $query->orWhere(function ($q) use ($senderId) {
            $q->where('sender_id', $senderId)
                ->where('receiver_id', Auth::id())
                ->whereNull('receiver_deleted_at');
        });
    }
}
