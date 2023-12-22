<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Location;


class PatientController extends Controller
{
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'location_id' => 'required|integer',
            ]);

            $patient = Patient::create([
                'name' => $request->input('name'),
                'location_id' => $request->input('location_id'),
            ]);

            return response()->json(['message' => 'Patient registered successfully', 'data' => $patient], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error registering Patient', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try{
            $request->validate([
                'name' => 'required|string',
                'location_id' => 'required|integer',
            ]);

            $patient = Patient::findOrFail($id);

            $patient->update([
                'name' => $request->input('name'),
                'location_id' => $request->input('location_id'),
            ]);

            return response()->json(['message' => 'Patient updated successfully', 'data' => $patient], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error updated Patient', 'error' => $e->getMessage()], 500);
        }
    }

    public function getPatient($id)
    {
        try {
            if (is_numeric($id)) {
                $patient = Patient::with('location')->find($id);
            } else {
                $patient = Patient::with('location')->where('name', $id)->first();
            }

            if (!$patient) {
                return response()->json(['message' => 'patient not found'], 404);
            }

            $location = $patient->location;

            return response()->json([
                'name' => $patient->name,
                'location_id' => $patient->location_id,
                'location_name' => $location ? $location->name : null,
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Error retrieving patient details', 'error' => $e->getMessage()], 500);
        }
    }
}
