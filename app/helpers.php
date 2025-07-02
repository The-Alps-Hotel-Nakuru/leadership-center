<?php

use Carbon\Carbon;

if (!function_exists('excelTime')) {
    function excelTime($excelTime)
    {
        if (!is_numeric($excelTime)) {
            return null;
        }

        // Excel time to seconds
        $seconds = (float)$excelTime * 86400; // 24 * 60 * 60

        return Carbon::createFromTimestamp($seconds)->format('h:i:s A');
    }
}
