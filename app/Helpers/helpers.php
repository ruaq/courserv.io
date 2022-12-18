<?php

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
