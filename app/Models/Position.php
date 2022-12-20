<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Position
 *
 * @property int $id
 * @property int|null $team_id
 * @property string $title
 * @property int|null $leading
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Team|null $team
 * @method static Builder|Position newModelQuery()
 * @method static Builder|Position newQuery()
 * @method static Builder|Position query()
 * @method static Builder|Position whereCreatedAt($value)
 * @method static Builder|Position whereDescription($value)
 * @method static Builder|Position whereId($value)
 * @method static Builder|Position whereLeading($value)
 * @method static Builder|Position whereTeamId($value)
 * @method static Builder|Position whereTitle($value)
 * @method static Builder|Position whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Position extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
}
