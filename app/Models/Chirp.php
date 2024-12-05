<?php

namespace App\Models;

use App\Events\ChirpCreated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Chirp extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['message'];

    /**
     * The events that are dispatched by the model.
     *
     * @var array<string, string>
     */
    protected $dispatchesEvents = [
        'created' => ChirpCreated::class,
    ];

    /**
     * Get the user that owns the chirp.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
