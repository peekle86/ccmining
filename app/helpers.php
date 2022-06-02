<?php

use Carbon\Carbon;

if( !function_exists('getBetween') ) {
    function getBetween($begins_at) {
        return array(
            $begins_at,
            Carbon::now()->endOfMonth()
        );
    }
}

if( !function_exists('getGraph') ) {
    function getGraph($graph_data, Carbon $user_registered, $sum = false) {
        $user_registered = $user_registered->startOfDay();
        $days_count = $user_registered->diffInDays(Carbon::now());
        $current_day = $user_registered;

        for ($i = 0; $i <= $days_count; $i++) {
            $day = str_pad($current_day->format('d'), 2, '0', STR_PAD_LEFT);
            $month = str_pad($current_day->format('m'), 2, '0', STR_PAD_LEFT);

            $index = $current_day->format('Y') . '-' . $month .'-'. $day;
            $label = $day . '.' . $month . '.' . $current_day->format('y');
            $graph['labels'][] = $label;
            if( isset($graph_data[$index]) ) {
                if($sum) {
                    $graph['data'][] = $graph_data[$index]->sum($sum);
                } else {
                    $graph['data'][] = $graph_data[$index]->count();
                }
            } else {
                $graph['data'][] = 0;
            }
            $current_day = $user_registered->addDay();
        }

        return $graph;
    }
}

if( !function_exists('getAdminGraph') ) {
    function getAdminGraph($graph_data, $month_count = 1, $sum = false) {
        $month_count++;
        $m = array();
        for($i=1; $i<=$month_count; $i++) {
            if( $i == 1 ) {
                $m[$i]['y'] = (int) date('y');
                $m[$i]['m'] = (int) date('m');
            } else {
                $m[$i]['y'] = ($m[$i-1]['m'] == 1) ? $m[$i-1]['y']-1 : $m[$i-1]['y'];
                $m[$i]['m'] = ($m[$i-1]['m'] == 1) ? 12 : $m[$i-1]['m']-1;
            }
        }
        asort($m);

        $graph = [];
        //dd(date('Y-m-d', mktime(0, 0, 0, date("m"), date("d")-90, date("Y"))));

        $date = new DateTime();
        $currDate = new DateTime();
        $ago90 = $date->sub(new DateInterval('P90D'));

        foreach ($m as $val) {
            $month_days[$val['m']] = cal_days_in_month(CAL_GREGORIAN, $val['m'], date('Y'));
            for($i=0; $i<$month_days[$val['m']]; $i++) {

                if( ($val['m'] == $ago90->format('m') && $i+1 > $ago90->format('d')) ||
                    ($val['m'] != $ago90->format('m') && ($val['m'] < $currDate->format('m') || $i < (int)$currDate->format('d')  )) ) {

                    $date = str_pad($i+1, 2, '0', STR_PAD_LEFT);
                    $month = str_pad($val['m'], 2, '0', STR_PAD_LEFT);

                    //$md = $val['y'] . '-' . $month .'-'. $date;
                    $md = $month .'-'. $date;
                    $graph['labels'][] = $md;
                    if( isset($graph_data[$md]) ) {
                        //dd($graph_data[$md]);
                        if( $sum ) {
                            $graph['data'][] = $graph_data[$md]->sum($sum);
                        } else {
                            $graph['data'][] = $graph_data[$md]->count();
                        }
                    } else {
                        $graph['data'][] = 0;
                    }
                }

            }
        }
        //dump($graph);
        return $graph;
    }
}
