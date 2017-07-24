<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Schedule;

class ScheduleController extends Controller
{

    public function index()
    {
        $scripts = ["js/moment.min.js", "js/bootstrap-datetimepicker.js", "js/fullcalendar.js", "js/schedule.js"];
        $styleSheets = ["css/fullcalendar.css", "css/bootstrap-datetimepicker.css"];
        
    	return view('schedule', compact('scripts', 'styleSheets'));
    }



    public function getJSON() 
    {
    	$schedules = Schedule::get();
    	return response()->json($schedules);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $schedule   = new Schedule;
        $schedule->start    	= (float)$request->start;
        $schedule->duration     = $request->duration;
        $schedule->end 			= $schedule->start + ($schedule->duration * 60 * 1000);
        $schedule->title        = $request->title;
        $schedule->save();
        return "true";
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    	$schedule = Schedule::find($id);
    	$schedule->start    	= $request->start;
    	$schedule->duration     = $request->duration;
    	$schedule->title        = $request->title;
    	$schedule->save();
    	return true;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $schedule = Schedule::find($id);
        $schedule->delete();
    }
}
