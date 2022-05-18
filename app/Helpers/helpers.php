<?php

/**
 * Format an amount to the given currency
 *
 * @return response()
 */

if (! function_exists('formatCurrency')) {
    function formatCurrency($amount, $currency)
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
