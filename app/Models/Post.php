<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    protected $table = 'posts';

    protected $fillable = [
        'title',
        'slug',
        'body',
        'author_id',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected function title(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Str::title($value),
            set: fn ($value) => strtolower(strip_tags($value)),
        );
    }

    protected function slug(): Attribute
    {
        // return Attribute::make(
        //     set: fn ($value) => Str::slug($value),
        // );

        return Attribute::make(
            set: function($value) {
                $slug = Str::slug($value);
                
                $count = 2;
                while(static::where('slug', $slug)->exists()) {
                    $slug = Str::slug($value . '-' . $count);
                    $count++;
                }

                return $slug;
            }
        );
    }

    protected function body(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => strip_tags($value),
        );
    }
}
