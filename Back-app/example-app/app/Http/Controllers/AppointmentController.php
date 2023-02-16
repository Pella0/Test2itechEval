<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Appointment;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    /**
     * Reserve an appointment for a given commercial and user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reserveAppointment(Request $request): JsonResponse
    {
        $request->validate([
            'commercial_id' => 'required|exists:commercials,id',
            'user_id' => 'required|exists:users,id',
            'appointment_time' => 'required|date_format:Y-m-d H:i:s'
        ]);

        $commercialId = $request->input('commercial_id');
        $userId = $request->input('user_id');
        $appointmentTime = Carbon::parse($request->input('appointment_time'));

        try {
            // Check if the appointment time is within working hours (9:30-17:30)
            if ($appointmentTime->hour < 9 || $appointmentTime->hour > 17) {
                return response()->json(['error' => 'Appointment time must be within working hours (9:30-17:30)'], 400);
            } elseif ($appointmentTime->hour === 17 && $appointmentTime->minute > 30) {
                return response()->json(['error' => 'Appointment time must be within working hours (9:30-17:30)'], 400);
            } elseif ($appointmentTime->hour === 9 && $appointmentTime->minute < 30) {
                return response()->json(['error' => 'Appointment time must be within working hours (9:30-17:30)'], 400);
            }

            // Check if the commercial is available at the appointment time
            $existingAppointment = Appointment::where('commercial_id', $commercialId)
                ->where('appointment_time', $appointmentTime)
                ->first();

            if ($existingAppointment) {
                return response()->json(['error' => 'Commercial is not available at the specified time'], 400);
            }

            // Create the new appointment
            $appointment = new Appointment([
                'commercial_id' => $commercialId,
                'user_id' => $userId,
                'appointment_time' => $appointmentTime
            ]);

            $appointment->save();
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Failed to reserve appointment'], 500);
        }

        return response()->json(['message' => 'Appointment reserved successfully']);
    }
}
