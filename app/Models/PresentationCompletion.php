<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PresentationCompletion
 *
 * @property int $id
 * @property string $session_id
 * @property \Illuminate\Support\Carbon $completed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|PresentationCompletion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PresentationCompletion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PresentationCompletion query()
 * @method static \Illuminate\Database\Eloquent\Builder|PresentationCompletion whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PresentationCompletion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PresentationCompletion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PresentationCompletion whereSessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PresentationCompletion whereUpdatedAt($value)
 * @method static \Database\Factories\PresentationCompletionFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class PresentationCompletion extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'session_id',
        'completed_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'completed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'presentation_completions';
}