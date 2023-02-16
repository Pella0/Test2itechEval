<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Commercial;
use App\Models\Appointment;
use Exception;

class CommercialController extends Controller
{
    /**
     * Get all commercials from the database.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllCommercial(): JsonResponse
    {
        try {
            $commercials = Commercial::all();
            return response()->json(['commercials' => $commercials]);
        } catch (Exception $e) {
            return response()->json(['message' => 'Unable to get commercials.'], 500);
        }
    }

    public function show(Request $request, $id): JsonResponse
    {
        $commercial = Commercial::find($id);

        if (!$commercial) {
            return response()->json([
                'message' => 'Commercial not found',
            ], 404);
        }

        return response()->json([
            'data' => $commercial,
        ]);
    }

    public function appointments(Request $request, $id): JsonResponse
    {
        $commercial = Commercial::find($id);

        if (!$commercial) {
            return response()->json([
                'message' => 'Commercial not found',
            ], 404);
        }

        $appointments = Appointment::where('commercial_id', $commercial->id)
            ->where('start_time', '>=', now()->startOfDay())
            ->where('start_time', '<=', now()->endOfDay())
            ->get();

        return response()->json([
            'data' => $appointments,
        ]);
    }
}
