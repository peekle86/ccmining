<?php

use Carbon\Carbon;

if( !function_exists('getBetween') ) {
    function getBetween($month_count) {
        return array(
            Carbon::now()->startOfMonth()->subMonth($month_count - 1),
            Carbon::now()->endOfMonth()
        );
    }
}

if( !function_exists('getGraph') ) {
    function getGraph($graph_data, $month_count = 1, $sum = false) {
        $month_count++;
        $m = array();
        for($i=1; $i<=$month_count; $i++) {
            if( $i == 1 ) {
                $m[$i]['y'] = (int) date('Y');
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

                    $md = $val['y'] . '-' . $month .'-'. $date;
//                    $md = $month .'-'. $date;
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


if( !function_exists('getGraphCount') ) {
    function getGraphCount($graph_data, $month_count = 1, $sum = false) {

        $month_count++;
        $m = array();
        for($i=1; $i<=$month_count; $i++) {
            if( $i == 1 ) {
                $m[$i]['y'] = (int) date('Y');
                $m[$i]['m'] = (int) date('m');
            } else {
                $m[$i]['y'] = ($m[$i-1]['m'] == 1) ? $m[$i-1]['y']-1 : $m[$i-1]['y'];
                $m[$i]['m'] = ($m[$i-1]['m'] == 1) ? 12 : $m[$i-1]['m']-1;
            }
        }
        asort($m);
        $graph = [];

        $date = new DateTime();
        $currDate = new DateTime();
        $ago90 = $date->sub(new DateInterval('P90D'));


        foreach ($m as $val) {
            $month_days[$val['m']] = cal_days_in_month(CAL_GREGORIAN, $val['m'], date('Y'));
            for($i=0; $i < $month_days[$val['m']]; $i++) {

                if( ($val['m'] == $ago90->format('m') && $i+1 > $ago90->format('d')) ||
                    ($val['m'] != $ago90->format('m') && ($val['m'] < $currDate->format('m') || $i < (int)$currDate->format('d')  )) ) {

                    $date = str_pad($i+1, 2, '0', STR_PAD_LEFT);
                    $month = str_pad($val['m'], 2, '0', STR_PAD_LEFT);

                    $md = $val['y'] . '-' . $month .'-'. $date;
//                    $md = $month .'-'. $date;
                    $graph['labels'][] = $md;

                    if( isset($graph_data[$md]) ) {
                        $graph['data'][] = $graph_data[$md][0]->count;
                    } else {
                        $graph['data'][] = 0;
                    }
                }
            }
        }

        return $graph;
    }
}
