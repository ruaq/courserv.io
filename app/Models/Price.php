<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Price
 *
 * @property int $id
 * @property int|null $team_id
 * @property int|null $cert_template_id
 * @property string $title
 * @property string|null $description
 * @property string $amount_net
 * @property string $amount_gross
 * @property string $currency
 * @property string $payment
 * @property int|null $tax_rate
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\CertTemplate|null $certTemplate
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Course[] $courses
 * @property-read int|null $courses_count
 * @property-read \App\Models\Team|null $team
 *
 * @method static \Database\Factories\PriceFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Price newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Price newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Price query()
 * @method static \Illuminate\Database\Eloquent\Builder|Price whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Price whereAmountGross($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Price whereAmountNet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Price whereCertTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Price whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Price whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Price whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Price whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Price wherePayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Price whereTaxRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Price whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Price whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Price whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Price extends Model
{
    use HasFactory;

    public const CURRENCY = [
        'EUR',
        'USD',
    ];

    public const SIGN = [
        'EUR' => '€',
        'USD' => '$',
    ];

    public const TAX = [
        '0' => '0 %',
        '7' => '7 %',
        '19' => '19 %',
    ];

    public function team(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function courses(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function certTemplate(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(CertTemplate::class);
    }
}
