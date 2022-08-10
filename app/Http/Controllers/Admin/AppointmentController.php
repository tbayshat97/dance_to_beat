<?php

namespace App\Http\Controllers\Admin;

use App\Models\Appointment;
use App\Enums\AppointmentStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $appointment = Appointment::all();

        $breadcrumbs = [
            ['link' => "admin", 'name' => "Dashboard"], ['name' => "Appointments"],
        ];

        $pageConfigs = ['pageHeader' => true];

        return view('backend.appointments.list', compact('appointment', 'breadcrumbs', 'pageConfigs'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function show(Appointment $appointment)
    {
        $breadcrumbs = [
            ['link' => "admin", 'name' => "Dashboard"], ['link' => "admin/appointment", 'name' => "Appointments"], ['name' => "Update"],
        ];

        $pageConfigs = ['pageHeader' => true];
        $appointmentStatuses = AppointmentStatus::asSelectArray();

        return view('backend.appointments.show', compact('appointment', 'breadcrumbs', 'pageConfigs', 'appointmentStatuses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appointment $appointment)
    {
        try {
            $appointment->status = $request->status;

            $appointment->save();

            return redirect()->back()->with('success', __('system-messages.update'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
