<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Http\Requests\EventStore;

class EventController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventStore $request) {
        $start = Carbon::parse($request->date_from);
        $end = Carbon::parse($request->date_to);
        $dateRange = CarbonPeriod::create($start, $end);

        $data = [];
        foreach($dateRange as $date) {
            if($request->days[$date->dayOfWeek]) {
                $data[] = array(
                    'title' => $request->event_name,
                    'date' => $date->format('Y-m-d')
                );
            }
        }

        Event::insert($data);

        return response()->json($data);
    }

}
