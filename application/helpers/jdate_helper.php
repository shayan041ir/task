<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('gregorian_to_jalali'))
{
    function gregorian_to_jalali($gy, $gm, $gd)
    {
        $g_d_m = [0,31,59,90,120,151,181,212,243,273,304,334];
        $gy2 = ($gm > 2) ? ($gy + 1) : $gy;
        $days = 355666 + (365 * $gy) + floor(($gy2 + 3) / 4)
               - floor(($gy2 + 99) / 100) + floor(($gy2 + 399) / 400)
               + $gd + $g_d_m[$gm - 1];
        $jy = -1595 + (33 * intval($days / 12053));
        $days %= 12053;
        $jy += 4 * intval($days / 1461);
        $days %= 1461;
        if ($days > 365) {
            $jy += intval(($days - 1) / 365);
            $days = ($days - 1) % 365;
        }
        $jm = ($days < 186) ? 1 + intval($days / 31) : 7 + intval(($days - 186) / 30);
        $jd = 1 + (($days < 186) ? ($days % 31) : (($days - 186) % 30));
        return [$jy, $jm, $jd];
    }
}

if ( ! function_exists('jalali_format'))
{
    /**
     * تاریخ میلادی → شمسی با جداکننده دلخواه
     */
    function jalali_format($gregorianDate, $sep = '/')
    {
        if(empty($gregorianDate)) return '';
        $ts = strtotime($gregorianDate);
        list($jy, $jm, $jd) = gregorian_to_jalali(
            date('Y', $ts),
            date('m', $ts),
            date('d', $ts)
        );
        return sprintf('%04d%s%02d%s%02d', $jy, $sep, $jm, $sep, $jd);
    }
}
