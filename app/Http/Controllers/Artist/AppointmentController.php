<?php

namespace App\Http\Controllers\Artist;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class AppointmentController extends Controller
{
    public function dashboard()
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
}
