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
    function getGraph($graph_data, $user_registered, $sum = false) {
        $days_count = $user_registered->diffInDays(Carbon::now());
        $days_count = $days_count !== 0 ? $days_count + 1 : $days_count;
        $current_day = $user_registered;

        for ($i = 0; $i <= $days_count; $i++) {
            $day = str_pad($current_day->format('d'), 2, '0', STR_PAD_LEFT);
            $month = str_pad($current_day->format('m'), 2, '0', STR_PAD_LEFT);

            $label = $current_day->format('Y') . '-' . $month .'-'. $day;
            $graph['labels'][] = $label;
            if( isset($graph_data[$label]) ) {
                if($sum) {
                    $graph['data'][] = $graph_data[$label]->sum($sum);
                } else {
                    $graph['data'][] = $graph_data[$label]->count();
                }
            } else {
                $graph['data'][] = 0;
            }
            $current_day = $user_registered->addDay();
        }

        return $graph;
    }
}

