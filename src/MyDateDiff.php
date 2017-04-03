<?php

class MyDateDiff {
    
    public $years;
    public $months;
    public $days;
    public $total_days;
    public $invert;
    
    public function __construct ($diff) {
        list($this->years, $this->months, $this->days,
            $this->total_days, $this->invert) = $diff;
    }
    
}
