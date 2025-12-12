<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event; 
use App\Models\Organizer;
use App\Models\OrganizerChart;
use App\Models\EventLocation;

class CreateEventController extends Controller
{
    public function showCreateEvent()
    {
        return view('dashboard.organizer.createEvent');
    }

    public function createEvent(Request $request)
    {
        $request->validate([
            'evt_name'        => 'required|string|max:255',
            'evt_details'     => 'required|string',
            'evt_date'        => 'required|date',
            'evt_loctn_name'  => 'required|string|max:255',
            'map_details'     => 'nullable|url|max:1000', // allow Google Maps link or nullable
        ]);

        // determine organizer id: prefer user's org_id if present, otherwise Auth id
        $orgId = Auth::user()->org_id ?? Auth::id();

        // Find organizer record
        $organizer = Organizer::where('org_id', $orgId)->first();
        if (! $organizer) {
            return back()->withErrors(['organizer' => 'Organizer record not found.'])->withInput();
        }

        DB::beginTransaction();

        try {
            // 1) create event
            $event = Event::create([
                'org_id' => $organizer->org_id,
                'evt_name' => $request->evt_name,
                'evt_details' => $request->evt_details,
                'evt_date' => $request->evt_date,
                'trsh_collected_kg' => 0,
            ]);

            // 2) create event_location row referencing the new event
            EventLocation::create([
                'evt_id' => $event->evt_id,
                'evt_loctn_name' => $request->evt_loctn_name,
                'map_details' => $request->map_details,
            ]);

            // 3) update organizer totals
            $organizer->increment('totl_evts_orgzd');

            // 4) update organizer_chart for the month of the event
            $month = intval(date('m', strtotime($request->evt_date))); // 1-12

            $chart = OrganizerChart::where('org_id', $organizer->org_id)
                ->where('month', $month)
                ->first();

            if ($chart) {
                $chart->increment('evts_orgzd_count');
            } else {
                OrganizerChart::create([
                    'org_id' => $organizer->org_id,
                    'month' => $month,
                    'evts_orgzd_count' => 1,
                    'totl_partpts_count' => 0,
                ]);
            }

            DB::commit();

            return redirect()->route('dashboard.organizer')
                ->with('success', 'Event and location created successfully.');

        } catch (\Throwable $e) {
            DB::rollBack();
            // log the exception in your real app: Log::error($e);
            return back()->withErrors(['error' => 'Failed to create event.'])->withInput();
        }
    }
}
