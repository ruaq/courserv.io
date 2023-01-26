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

/**
 * Format an amount to the given currency
 *
 * @return response()
 */

use Illuminate\Support\Facades\Auth;

if (! function_exists('formatCurrency')) {
    function formatCurrency($amount, $currency): bool|string
    {
        $fmt = new NumberFormatter(app()->getLocale(), NumberFormatter::CURRENCY);

        return $fmt->formatCurrency($amount, $currency);
    }
}

if (! function_exists('percentage')) {
    function percentage($total, $part): int
    {
        $rest = $total - $part;

        return $rest / $total * 100;
    }
}

if (! function_exists('canonical_url')) {
    function canonical_url(): string
    {
        if (! \Illuminate\Support\Str::startsWith($current = url()->current(), config('app.url'))) {
            // replace domain if it's not the configured one
            $current = preg_replace(
                '/^(?:https?:\/\/)?(?:[^@\/\n]+@)?(?:www\.)?([^:\/\n]+)/',
                config('app.url'),
                $current
            );
        }

        return LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), $current);
    }
}

// function to get an array of teams to a permission
if (! function_exists('authorizedTeams')) {
    function authorizedTeams($permission): array
    {
        $team_ids = [];
        $teams = Auth::user()->teams()->pluck('id');

        foreach ($teams as $team) {
            if (Auth::user()->isAbleTo($permission, $team)) {
                $team_ids[]['team_id'] = $team;
            }
        }

        return $team_ids;
    }
}

// function to correct geolocations before importing
if (! function_exists('correctGeolocation')) {
    function correctGeolocation($location): mixed
    {
        if (strpos($location, ',')) { // remove addons like 'Stadt'
            $name = explode(',', $location);
            $location = $name[0];
        }

        if (strpos($location, ' / ')) { // remove the part after ' / '
            $name = explode(' / ', $location);
            $location = $name[0];
        }

        if (strpos($location, ' - ')) { // remove the part after ' - '
            $name = explode(' - ', $location);
            $location = $name[0];
        }

        if (preg_match('/([a](\.[d])(\.[A-Z]))/', $location)) {
            $location = str_replace('a.d.', 'an der ', $location);
        }

        if ($location === 'Neukirchen b.Hl.Blut') {
            $location = 'Neukirchen beim Heiligen Blut';
        }

        if ($location === 'Krauschwitz i.d. O.L.') {
            $location = 'Krauschwitz';
        }

        if ($location === 'Kirchheim i.Schw.') {
            $location = 'Kirchheim in Schwaben';
        }

        if ($location === 'Höchst i. Odw.') {
            $location = 'Höchst im Odenwald';
        }

        if (preg_match('/b\.[A-Z]/', $location)) {
            $location = str_replace('b.', 'bei ', $location);
        }

        if (preg_match('/b\.\s[A-Z]/', $location)) {
            $location = str_replace('b.', 'bei', $location);
        }

        if (strpos($location, 'i.d.OPf.')) {
            $location = $location = str_replace('i.d.OPf.', 'in der Oberpfalz', $location);
        }

        if (strpos($location, 'i.OB')) {
            $location = $location = str_replace('i.OB', 'in Oberbayern', $location);
        }

        if (strpos($location, 'i.NB')) {
            $location = $location = str_replace('i.NB', 'in Niederbayern', $location);
        }

        if (strpos($location, 'i.UFr.')) {
            $location = $location = str_replace('i.UFr.', 'in Unterfranken', $location);
        }

        if (strpos($location, 'i.OFr.')) {
            $location = $location = str_replace('i.OFr.', 'in Oberfranken', $location);
        }

        if (strpos($location, 'i.Bay.')) {
            $location = $location = str_replace('i.Bay.', 'in Bayern', $location);
        }

        if (preg_match('/i\.d\.[A-Z]/', $location)) {
            $location = str_replace('i.d.', 'in der ', $location);
        }

        if (preg_match('/i\.[A-Z]/', $location)) {
            $location = str_replace('i.', 'im ', $location);
        }

        if (preg_match('/a\.[A-Z]/', $location)) {
            $location = str_replace('a.', 'am ', $location);
        }

        if (preg_match('/a\.\sd\./', $location)) {
            $location = str_replace('a. d.', 'an der', $location);
        }

        if (preg_match('/a\.d\./', $location)) {
            $location = str_replace('a.d.', 'an der', $location);
        }

        if (preg_match('/a\.\s[A-Z]/', $location)) {
            $location = str_replace('a.', 'am', $location);
        }

        if (preg_match('/v\.d\.[A-Z]/', $location)) {
            $location = str_replace('v.d.', 'vor der ', $location);
        }

        if (preg_match('/v\.\sd\./', $location)) {
            $location = str_replace('v. d.', 'vor der', $location);
        }

        return $location;
    }
}
