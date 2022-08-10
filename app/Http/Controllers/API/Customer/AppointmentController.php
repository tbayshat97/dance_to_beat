<?php

namespace App\Http\Controllers\API\Customer;

use App\Enums\AppointmentStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\AppointmentRequest;
use App\Http\Resources\Appointment as ResourcesAppointment;
use App\Http\Resources\AppointmentCollection;
use App\Models\Appointment;
use App\Models\Artist;
use App\Models\ArtistAvailableTime;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    use ApiResponser;

    public function list()
    {
        $customer = auth()->user();
        $allMonths = allMonths();
        $thisYear = Carbon::now()->format('Y');

        $upcomingAppointments = [];
        $previousAppointments = [];

        foreach ($allMonths as $index => $month) {

            $appointments = $customer->appointments()
                ->where('status', AppointmentStatus::Confirmed)
                ->whereYear('date', $thisYear)->whereMonth('date', $month)
                ->get();

            $upcomingAppointments[$index] = new AppointmentCollection($appointments);
        }

        foreach ($allMonths as $index => $month) {
            $appointments = $customer->appointments()
                ->where('status', AppointmentStatus::Completed)
                ->whereYear('date', $thisYear)->whereMonth('date', $month)
                ->get();

            $previousAppointments[$index] = new AppointmentCollection($appointments);
        }

        $data = [
            'upcoming_appointments' => $upcomingAppointments,
            'previous_appointments' => $previousAppointments
        ];

        return $this->successResponse(200, trans('api.public.done'), 200, $data);
    }

    public function book(AppointmentRequest $request, Artist $artist)
    {
        $customer = auth()->user();

        $isExists = Appointment::where('artist_id', $artist->id)
            ->whereNotIn('status', [AppointmentStatus::Cancelled])
            ->where('date', $request->date)
            ->count();

        if ($isExists) {
            return $this->errorResponse(409, trans('api.public.exist'), 200);
        }

        $appointment = new Appointment();
        $appointment->customer_id = $customer->id;
        $appointment->artist_id = $artist->id;
        $appointment->date = $request->date;
        $appointment->status = AppointmentStatus::Pending;
        $appointment->total_cost = $artist->profile->price_per_hour;
        $appointment->save();

        return $this->successResponse(200, trans('api.public.done'), 200, new ResourcesAppointment($appointment));
    }

    public function artistAvailableTime(Request $request)
    {
        $availableTimes = ArtistAvailableTime::where('artist_id', $request->artist_id)->where('date', $request->date)->orderBy('time', 'asc')->get()
            ->each(function ($singleTime) {
                $singleTime->time = Carbon::createFromFormat('H:i:s', $singleTime->time)->format('H:i a');
            })->pluck('time')->toArray();

        return $this->successResponse(
            200,
            trans('api.public.done'),
            200,
            ['available-times' => $availableTimes ? $availableTimes : $this->hoursRange(0, 86400, 60 * 15)]
        );
    }

    function hoursRange($lower = 0, $upper = 86400, $step = 3600, $format = 'H:i a')
    {
        $times = [];

        foreach (range($lower, $upper, $step) as $increment) {
            $increment = gmdate('H:i', $increment);

            list($hour, $minutes) = explode(':', $increment);

            $date = new DateTime($hour . ':' . $minutes);

            $times[] = $date->format($format);
        }

        array_pop($times);

        return $times;
    }
}
