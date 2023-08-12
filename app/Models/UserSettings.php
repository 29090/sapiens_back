<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\Diff\Diff;

class UserSettings extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'language_id',
        'difficulty_id'
    ];

    public function scopeOfCurrentUser(Builder $query)
    {
        $query->where('user_id', Auth::user()->id);
    }

    public function difficulty(): BelongsTo
    {
        return $this->belongsTo(Difficulty::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
