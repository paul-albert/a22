<?php

class MyDateTest extends PHPUnit_Framework_TestCase {

    public function testSimpleTotalDays () {
        $this->assertTotalDays('2014/01/01', '2014/01/04');
    }

    public function testSimpleDays () {
        $this->assertDays('2014/01/01', '2014/01/04');
    }

    public function testSimpleMonths () {
        $this->assertMonths('2014/01/01', '2014/03/01');
    }

    public function testSimpleYears () {
        $this->assertYears('2014/01/01', '2015/01/01');
    }

    public function testInvertDayTrue () {
        $this->assertInvert('2015/01/02', '2015/01/01');
    }

    public function testInvertMonthTrue () {
        $this->assertInvert('2015/02/02', '2015/01/01');
    }

    public function testInvertYearTrue () {
        $this->assertInvert('2016/01/01', '2015/01/01');
    }

    public function testInvertDayFalse () {
        $this->assertInvert('2015/01/01', '2015/01/02');
    }

    public function testInvertMonthFalse () {
        $this->assertInvert('2015/01/01', '2015/02/01');
    }

    public function testInvertYearFalse () {
        $this->assertInvert('2015/01/01', '2016/01/01');
    }

    public function testComplexTotalDays () {
        $this->assertTotalDays('2013/01/01', '2015/05/15');
    }

    public function testComplexDays () {
        $this->assertDays('2013/03/21', '2015/07/31');
    }

    public function testInvertedComplexDays () {
        foreach ([
            '2013/03/21' => '2012/03/20',
            '2013/04/01' => '2012/03/20',
            '2012/04/20' => '2012/02/20',
            '2013/05/21' => '2012/04/20',
            '2015/08/01' => '2012/09/10',
        ] as $k => $v) {
            $this->assertDays($k, $v);
        }
    }

    public function testComplexMonths () {
        $this->assertMonths('2013/06/15', '2015/03/01');
    }

    public function testInvertedComplexMonths() {
        foreach ([
            '2014/04/21' => '2013/04/20',
            '2013/05/01' => '2012/05/20',
            '2012/06/20' => '2012/06/20',
            '2013/07/21' => '2012/07/20',
            '2015/08/01' => '2012/08/10',
        ] as $k => $v) {
            $this->assertMonths($k, $v);
        }
    }
    
    public function testComplexYears () {
        $this->assertYears('2013/09/13', '2015/07/01');
    }

    public function testInvertedComplexYears () {
        foreach ([
            '2014/04/21' => '2013/04/20',
            '2013/05/01' => '2012/05/20',
            '2012/06/20' => '2011/06/20',
            '2013/07/21' => '2012/07/20',
            '2015/08/01' => '2014/08/10',
        ] as $k => $v) {
            $this->assertYears($k, $v);
        }
    }

    public function testLeapYearTotalDays () {
        $this->assertTotalDays('2013/01/01', '2017/05/15');
    }

    public function testLeapYearDays () {
        $this->assertDays('2013/03/21', '2017/07/31');
    }

    public function testLeapYearMonths () {
        $this->assertMonths('2013/06/15', '2017/03/01');
    }

    public function testLeapYearYears () {
        $this->assertYears('2013/09/13', '2017/07/01');
    }

    public function testInvertLeapYearTrue () {
        $this->assertInvert('2017/03/16', '2013/06/18');
    }

    public function testMultipleLeapYearTotalDays () {
        $this->assertTotalDays('2013/01/01', '2029/05/15');
    }

    public function testMultipleLeapYearDays () {
        $this->assertDays('2013/03/21', '2028/07/31');
    }

    public function testMultipleLeapYearMonths () {
        $this->assertMonths('2013/06/15', '2029/03/01');
    }

    public function testMultipleLeapYearYears () {
        $this->assertYears('2013/09/13', '2029/07/01');
    }

    public function testInvertMultipleLeapYearTrue () {
        $this->assertInvert('2029/03/16', '2013/06/18');
    }

    private function assertYears ($s, $e) {
        $d = MyDate::diff($s, $e);
        $a = $this->dateDiff($s, $e);
        $this->assertSame($a->y, $d->years);
    }

    private function assertMonths ($s, $e) {
        $d = MyDate::diff($s, $e);
        $a = $this->dateDiff($s, $e);
        $this->assertSame($a->m, $d->months);
    }

    private function assertDays ($s, $e) {
        $d = MyDate::diff($s, $e);
        $a = $this->dateDiff($s, $e);
        $this->assertSame($a->d, $d->days);
    }

    private function assertTotalDays ($s, $e) {
        $d = MyDate::diff($s, $e);
        $a = $this->dateDiff($s, $e);
        $this->assertSame($a->days, $d->total_days);
    }

    private function assertInvert ($s, $e) {
        $d = MyDate::diff($s, $e);
        $a = $this->dateDiff($s, $e);
        $this->assertSame((bool)$a->invert, $d->invert);
    }

    private function dateDiff ($s, $e) {
        $d1 = DateTime::createFromFormat('Y/m/d', $s);
        $d2 = DateTime::createFromFormat('Y/m/d', $e);
        return $d1->diff($d2);
    }
}
