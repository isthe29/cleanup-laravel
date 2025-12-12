<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Volunteer;
use App\Models\VolunteerChart;
use App\Models\User;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class VolunteerController extends Controller
{
    // Dashboard
    public function index()
    {
        $userId = auth()->id();
        $user = User::find($userId);

        $volunteer = Volunteer::where('vol_id', $userId)->first();
        if (!$volunteer) {
            return redirect()->back()->with('error', 'Volunteer data not found.');
        }
        $volunteer->usr_name = $user->usr_name;

        // Monthly chart data
        $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        $eventsParticipatedPerMonth = [];
        $trashCollectedPerMonth = [];

        foreach ($months as $index => $monthName) {
            $monthNumber = $index + 1;
            $chartData = VolunteerChart::where('vol_id', $volunteer->vol_id)
                ->whereMonth('created_at', $monthNumber)
                ->first();
            
            $eventsParticipatedPerMonth[] = $chartData ? $chartData->evts_partd_count : 0;
            $trashCollectedPerMonth[] = $chartData ? $chartData->trash_collected_kg ?? 0 : 0;
        }

        // Upcoming events not yet joined
        $upcomingEvents = Event::where('evt_date', '>=', Carbon::today())
            ->whereDoesntHave('participants', function($q) use ($volunteer) {
                $q->where('vol_id', $volunteer->vol_id);
            })
            ->orderBy('evt_date')
            ->get();

        // Joined events
        $joinedEvents = Event::whereHas('participants', function($q) use ($volunteer) {
            $q->where('vol_id', $volunteer->vol_id);
        })->orderBy('evt_date')->get();

        return view('dashboard.volunteer.index', [
            'volunteer' => $volunteer,
            'eventsParticipatedPerMonth' => $eventsParticipatedPerMonth,
            'trashCollectedPerMonth' => $trashCollectedPerMonth,
            'upcomingEvents' => $upcomingEvents,
            'joinedEvents' => $joinedEvents
        ]);
    }

    // Join an event
    public function joinEvent($eventId)
    {
        $userId = auth()->id();
        $volunteer = Volunteer::where('vol_id', $userId)->first();
        if (!$volunteer) {
            return redirect()->back()->with('error', 'Volunteer data not found.');
        }

        $event = Event::find($eventId);
        if (!$event) {
            return redirect()->back()->with('error', 'Event not found.');
        }

        // Check if already joined
        $alreadyJoined = DB::table('event_participation')
            ->where('vol_id', $volunteer->vol_id)
            ->where('evt_id', $event->evt_id)
            ->exists();

        if ($alreadyJoined) {
            return redirect()->back()->with('error', 'You already joined this event.');
        }

        // Insert participation
        DB::table('event_participation')->insert([
            'vol_id' => $volunteer->vol_id,
            'evt_id' => $event->evt_id,
            'status' => 'joined',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Update currently joined events count
        $volunteer->evt_curr_joined = DB::table('event_participation')
            ->where('vol_id', $volunteer->vol_id)
            ->count();
        $volunteer->save();

        return redirect()->back()->with('success', 'Successfully joined the event!');
    }
}
