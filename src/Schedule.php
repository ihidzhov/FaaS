<?php 

namespace Ihidzhov\FaaS;

class Schedule {

    const MINUTE = 0;
    const HOUR = 1;
    const DAY = 2;
    const MONTH = 3;
    const WEEK = 4;

    private array $schedule = [];
    
    public function setSchedule(array $schedule) {
        $this->schedule = $schedule;
    }

    public function isReadyToRun() {
        $week = date("w");
        $month = date("m");
        $day = date("d");
        $hour = date("H");
        $minute = date("i"); 
        
        if ($this->isWeek($week) && $this->isMonth($month) && $this->isDay($day) &&
            $this->isHour($hour) && $this->isMinute($minute)
        ) {
            return true;
        }
        return false;
    }

    public function isMinute(int $minuteNow) {
        $minute = $this->schedule[self::MINUTE];
        return $this->is($minuteNow,$minute);
    }

    public function isHour(int $hourNow) {
        $hour = $this->schedule[self::HOUR];
        return $this->is($hourNow,$hour);
    }

    public function isDay(int $dayNow) {
        $day = $this->schedule[self::DAY];
        return $this->is($dayNow,$day);
    }

    public function isMonth(int $monthNow) {
        $month = $this->schedule[self::MONTH];
        return $this->is($monthNow,$month);
    }

    public function isWeek(int $weekNow) {
        $week = $this->schedule[self::WEEK];
        return $this->is($weekNow,$week);
    }
 
    protected function is($now, $scheduled) {
        if ($scheduled == "*") {
            return true;
        }
        if ($this->isStep($scheduled)) {
           $steps = $this->patternToArray("/",$scheduled);
           var_dump($steps);
           if (is_array($steps) && $steps[0] == "*") {
                if ($this->isList($steps[1])) {
                    // $list = $this->patternToArray(",",$steps[1]);
                    // if (in_array($now, $list)) {
                    //     return true;
                    // }
                    $list = $this->patternToArray(",",$steps[1]);
                    foreach($list as $v) {
                        if ($v > 30) {
                            if ($now == $v) {
                                return true;
                            }
                        } else {
                            if ($now % $v == 0) {
                                return true;
                            } 
                        }
                    }
                } else {
                    if ($steps[1] > 30) {
                        if ($now == $steps[1]) {
                            return true;
                        }
                    } else {
                        if ($now % $steps[1] == 0) {
                            return true;
                        } 
                    }
                }
           }
        } elseif ($this->isRange($scheduled)) {
            $range = $this->patternToArray("-",$scheduled);
            if (is_array($range) && isset($range[0]) && isset($range[1])) {
                $rng = range((int)$range[0], (int)$range[1]);
                if (in_array($now, $rng)) {
                    return true;
                }
            }
        } elseif ($this->isList($scheduled)) {
            $list = $this->patternToArray(",",$scheduled);
            if (in_array($now, $list)) {
                return true;
            }
        } elseif($scheduled == $now) {
            return true;
        }
        return false;
    }

    protected function isList($value) {
        if (str_contains($value, ",")) {
            return true;
        }
        return false;
    }

    protected function isRange($value) {
        if (str_contains($value, "-")) {
            return true;
        }
        return false;
    }

    protected function isStep($value) :array|bool {
        if (str_contains($value, "/")) {
            return true;
        }
        return false;
    }

    protected function patternToArray($pattern, $value) {
        return explode($pattern, $value);
    }

    public function crontabToArray(string $pattern) :array {
        $pattern = trim($pattern);
        $ar = explode(" ", $pattern);
        if (!is_array($ar) || count($ar) < 5) {
            return [];
        }
        return $ar;
    }
}