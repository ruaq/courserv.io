<?php

/*
| Copyright 2023 courservio.de
|
| Licensed under the EUPL, Version 1.2 or – as soon they
| will be approved by the European Commission - subsequent
| versions of the EUPL (the "Licence");
| You may not use this work except in compliance with the
| Licence.
| You may obtain a copy of the Licence at:
|
| https://joinup.ec.europa.eu/software/page/eupl
|
| Unless required by applicable law or agreed to in
| writing, software distributed under the Licence is
| distributed on an "AS IS" basis,
| WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
| express or implied.
| See the Licence for the specific language governing
| permissions and limitations under the Licence.
*/

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
