<?php

class MyDate {
    
    const DAYS_PER_YEAR = 365;
    
    /**
     * Checks for is year leap or not.
     * 
     * @param   integer     $year - year for check
     * 
     * @return  boolean
     */
    private static function isYearLeap ($year) {
        return (!($year % 4) && ($year % 100)) || !($year % 400);
    }

    /**
     * Generates array of days amount for months in year.
     * 
     * @param integer   $year - year that we need to get months days
     * 
     * @return array
     */
    private static function getMonthDays ($year) {
        return [
            31,                                 // January
            self::isYearLeap($year) ? 28 : 29,  // February
            31,                                 // March
            30,                                 // April
            31,                                 // May
            30,                                 // June
            31,                                 // July
            31,                                 // August
            30,                                 // September
            31,                                 // October
            30,                                 // November
            31,                                 // December
        ];
    }
    
    /**
     * Checks for to swap dates if first is less than second.
     * Also sets invert parameter.
     * 
     * @param array     $d1 - array with info about year/month/day
     * @param array     $d2 - array with info about year/month/day
     * 
     * @return array
     */
    private static function checkForSwap ($d1, $d2) {
        $invert = false;
        for ($i = 0, $d2_count = count($d2); $i < $d2_count; $i++) {
            if ($d2[$i] > $d1[$i]) {
                break;
            }
            if ($d2[$i] < $d1[$i]) {
                list($d1, $d2) = [$d2, $d1];
                $invert = true;
                break;
            }
        }        
        return [$d1, $d2, $invert];
    }
    
    /**
     * Calculates total count of days between dates.
     * 
     * @param array     $d1 - array with info about year/month/day
     * @param array     $d2 - array with info about year/month/day
     * 
     * @return integer
     */
    private static function totalDays ($d1, $d2) {
        list($year1, $month1, $day1) = $d1;
        list($year2, $month2, $day2) = $d2;
        $tmp = $year1;
        
        $td1 = self::sumOfDays($month1);
        for ($i = $tmp; $i < $year1; $i++) {
            if (self::isYearLeap($i)) {
                $td1++;
            }
        }
        $td1 += $day1 + ($year1 - $tmp) * self::DAYS_PER_YEAR;
        
        $td2 = 0;
        for ($i = $tmp; $i < $year2; $i++) {
            if (self::isYearLeap($i)) {
                $td2++;
            }
        }
        $td2 += self::sumOfDays($month2);
        $td2 += $day2 + (($year2 - $tmp) * self::DAYS_PER_YEAR);
        
        return $td2 - $td1;
    }
    
    /**
     * Calculates sum of days for month in year.
     * 
     * @param integer   $month - month for calculation
     * 
     * @return int
     */
    private static function sumOfDays ($month) {
        $sum = 0;
        switch ($month) {
            case 1:     $sum =   0; break;     // 0
            case 2:     $sum =  31; break;     // 0 + 31
            case 3:     $sum =  59; break;     // 31 + 28
            case 4:     $sum =  90; break;     // 59 + 31
            case 5:     $sum = 120; break;     // 90 + 30
            case 6:     $sum = 151; break;     // 120 + 31
            case 7:     $sum = 181; break;     // 151 + 30
            case 8:     $sum = 212; break;     // 181 + 31
            case 9:     $sum = 243; break;     // 212 + 31
            case 10:    $sum = 273; break;     // 243 + 30
            case 11:    $sum = 304; break;     // 273 + 31
            case 12:    $sum = 334; break;     // 304 + 30
            default:    $sum =   0; break;     // unknown case   
        }
        return $sum;
    }
    
    /**
     * Fills dates difference info.
     * 
     * @param array     $d1 - array with info about year/month/day
     * @param array     $d2 - array with info about year/month/day
     * @param boolean   $invert - do we have inverted dates difference
     * 
     * @return array
     */
    private static function fillDateDiff ($d1, $d2, $invert) {
        $monthDays = self::getMonthDays($d1[0]);
        
        $totalDays = self::totalDays($d1, $d2);
        
        $diff = [null, null, null, $totalDays, $invert];
        $min = [null, 1, 1];
        $max = [null, 12, $monthDays[$d1[1] - 1]];
        
        for ($i = 2; $i > 0; $i--) {
            if ($d1[$i] > $max[$i]){
                $d1[$i - 1]++;
                $d1[$i] = $min[$i];
            }
            if ($d2[$i] < $d1[$i]) {
                $d1[$i-1]++;
                $diff[$i] = $d2[$i] + ($max[$i] - $min[$i] + 1) - $d1[$i];
            } else {
                $diff[$i] = $d2[$i] - $d1[$i];
            }
        }
        $diff[0] = $d2[0] - $d1[0];
        return $diff;
    }

    /**
     * Makes difference for start and end dates.
     * Returns \MyDateDiff object.
     * 
     * @param string        $start - string with start date
     * @param string        $end - string with end date
     * 
     * @return \MyDateDiff
     */
    public static function diff ($start, $end) {
        $s = array_map('intval', explode('/', $start));
        $e = array_map('intval', explode('/', $end));

        list($d1, $d2, $invert) = self::checkForSwap($s, $e);
        
        $diff = self::fillDateDiff($d1, $d2, $invert);
        
        return new MyDateDiff($diff);
    }

}
