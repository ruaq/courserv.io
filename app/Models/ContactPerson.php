<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ContactPerson
 *
 * @property int $id
 * @property int|null $team_id
 * @property string $lastname
 * @property string $firstname
 * @property string|null $company
 * @property string|null $street
 * @property string|null $zipcode
 * @property string|null $location
 * @property string|null $phone
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|ContactPerson newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactPerson newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactPerson query()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactPerson whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactPerson whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactPerson whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactPerson whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactPerson whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactPerson whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactPerson whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactPerson wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactPerson whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactPerson whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactPerson whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactPerson whereZipcode($value)
 * @mixin \Eloquent
 */
class ContactPerson extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'lastname',
        'firstname',
        'company',
        'street',
        'zipcode',
        'location',
        'phone',
        'email',
    ];
}
