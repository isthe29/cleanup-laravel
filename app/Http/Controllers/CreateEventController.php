<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event; 
use App\Models\Organizer;
use App\Models\OrganizerChart;
use App\Models\EventLocation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CreateEventController extends Controller
{
    public function showCreateEvent()
    {
        return view('dashboard.organizer.createEvent');
    }

    public function createEvent(Request $request)
    {
        // Validate input
        $request->validate([
            'evt_name'        => 'required|string|max:255',
            'evt_details'     => 'required|string',
            'evt_date'        => 'required|date',
            'evt_loctn_name'  => 'required|string|max:255',
            'map_details'     => 'nullable|string',
        ]);

        // Determine organizer id
        $orgId = Auth::user()->org_id ?? Auth::id();

        // Find organizer record
        $organizer = Organizer::where('org_id', $orgId)->first();
        if (!$organizer) {
            return back()->withErrors(['organizer' => 'Organizer record not found.'])->withInput();
        }

        // --- Handle Google Maps embed safely ---
        $mapInput = $request->map_details;
        $safeMapUrl = null;

        if ($mapInput) {
            // If user pasted a full iframe, extract src
            if (Str::contains($mapInput, '<iframe')) {
                preg_match('/src="([^"]+)"/', $mapInput, $matches);
                $srcUrl = $matches[1] ?? null;
                if ($srcUrl && Str::startsWith($srcUrl, 'https://www.google.com/maps/embed')) {
                    $safeMapUrl = $srcUrl;
                }
            } else {
                // If user pasted a direct share URL, convert to embed
                if (Str::startsWith($mapInput, 'https://goo.gl') || Str::startsWith($mapInput, 'https://maps.app.goo.gl')) {
                    // Use Google Maps "place" embed format
                    // Users can still paste normal Google Maps URL as-is
                    $safeMapUrl = str_replace('/maps/', '/maps/embed?', $mapInput);
                } elseif (Str::startsWith($mapInput, 'https://www.google.com/maps/embed')) {
                    $safeMapUrl = $mapInput;
                }
            }
        }

        DB::beginTransaction();

        try {
            // Create Event
            $event = Event::create([
                'org_id' => $organizer->org_id,
                'evt_name' => $request->evt_name,
                'evt_details' => $request->evt_details,
                'evt_date' => $request->evt_date,
                'trsh_collected_kg' => 0,
            ]);

            if (!$event) {
                throw new \Exception('Event creation failed.');
            }

            // Create EventLocation with safe map URL
            $eventLocation = EventLocation::create([
                'evt_id' => $event->evt_id,
                'evt_loctn_name' => $request->evt_loctn_name,
                'map_details' => $safeMapUrl,
            ]);

            if (!$eventLocation) {
                throw new \Exception('Event Location creation failed.');
            }

            // Update organizer totals
            $organizer->increment('totl_evts_orgzd');

            // Update organizer chart for the month
            $month = intval(date('m', strtotime($request->evt_date))); // 1-12

            $chart = OrganizerChart::firstOrNew([
                'org_id' => $organizer->org_id,
                'month' => $month
            ]);

            $chart->evts_orgzd_count = ($chart->evts_orgzd_count ?? 0) + 1;
            $chart->totl_partpts_count = $chart->totl_partpts_count ?? 0;
            $chart->save();

            DB::commit();

            return redirect()->route('dashboard.organizer')
                ->with('success', 'Event and location created successfully.');

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('CreateEventController Error: '.$e->getMessage().' in '.$e->getFile().' line '.$e->getLine());

            return back()->withErrors([
                'error' => 'Failed to create event. ' . $e->getMessage()
            ])->withInput();
        }
    }
}
