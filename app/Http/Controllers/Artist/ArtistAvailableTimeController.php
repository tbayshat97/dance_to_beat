<?php

namespace App\Http\Controllers\Artist;

use App\Http\Controllers\Controller;
use App\Http\Requests\Artist\AddAvailableTime;
use App\Models\ArtistAvailableTime;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class ArtistAvailableTimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $artist = auth('artist')->user();

        try {
            $dateFrom = Carbon::now()->addMonths(-6)->format('Y-m-d');
            $dateTo = Carbon::now()->addMonths(6)->format('Y-m-d');
            $period = CarbonPeriod::create($dateFrom, $dateTo);
            $dates = [];

            foreach ($period as $date) {
                $overwrited_date = $artist->availableTimes()->where('date', $date->format('Y-m-d'))->get();

                $temp = [
                    'id' => $date->format('Y-m-d'),
                    'title' => 'Default',
                    'start' => $date->format('Y-m-d'),
                    'color' => '#673ab7'
                ];

                if (count($overwrited_date)) {
                    foreach ($overwrited_date as $value) {
                        $temp['title'] = Carbon::createFromFormat('H:i:s', $value->time)->format('H:i a');

                        $color = getRandomColor();

                        $temp['color'] = $color;
                        $dates[] = $temp;
                    }
                } else {
                    $dates[] = $temp;
                }
            }
            return response()->json($dates);
        } catch (\Exception $e) {
            return response()->json([
                'fail' => true,
                'message' => 'failed due to:' . $e->getMessage(),
            ], 200);
        }
    }

    public function showSingleDateAvailableTimes($date)
    {
        $artist = auth('artist')->user();
        $availableTimes = $artist->availableTimes()->where('date', $date)->orderBy('time', 'asc')->get();

        return view('backend-artist.available-times.show', compact('date', 'availableTimes'));
    }

    public function updateSingleDateAvailableTimes(AddAvailableTime $request, $date)
    {
        $artist = auth('artist')->user();

        if ($request->available_times_old) {
            $old_available_times_ids = [];
            foreach ($request->available_times_old as $item) {
                array_push($old_available_times_ids, $item['id']);
                $artistAvailableTime = ArtistAvailableTime::find($item['id']);
                $artistAvailableTime->time = $item['available_times_time'];
                $artistAvailableTime->save();
            }

            tap(ArtistAvailableTime::where('artist_id', $artist->id)->where('date', $date)->whereNotIn('id', $old_available_times_ids)->delete());
        } else {
            tap(ArtistAvailableTime::where('artist_id', $artist->id)->where('date', $date)->delete());
        }

        if ($request->available_times) {
            foreach ($request->available_times as $item) {
                $artistAvailableTime = new ArtistAvailableTime();
                $artistAvailableTime->artist_id = $artist->id;
                $artistAvailableTime->date = $date;
                $artistAvailableTime->time = $item['available_times_time'];
                $artistAvailableTime->save();
            }
        }

        return redirect(route('artist.dashboard'))->with('success', __('system-messages.update'));
    }
}
