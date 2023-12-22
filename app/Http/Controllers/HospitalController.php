<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hospital;
use App\Models\Location;


class HospitalController extends Controller
{
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'location_id' => 'required|integer',
            ]);
            $hospital = Hospital::create([
                'name' => $request->input('name'),
                'location_id' => $request->input('location_id'),
            ]);

            return response()->json(['message' => 'Hospital registered successfully', 'data' => $hospital], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error registering hospital', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {

            $request->validate([
                'name' => 'required|string',
                'location_id' => 'required|integer',
            ]);
            
            $hospital = Hospital::findOrFail($id);
            $hospital->update([
                'name' => $request->input('name'),
                'location_id' => $request->input('location_id'),
                
            ]);
            
            return response()->json(['message' => 'Hospital updated successfully', 'data' => $hospital], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error updating hospital', 'error' => $e->getMessage()], 500);
        }
    }

    public function getHospital($id)
    {
        try {
            if (is_numeric($id)) {
                $hospital = Hospital::with('location')->find($id);
            } else {
                $hospital = Hospital::with('location')->where('name', $id)->first();
            }

            if (!$hospital) {
                return response()->json(['message' => 'Hospital not found'], 404);
            }

            $location = $hospital->location;

            return response()->json([
                'name' => $hospital->name,
                'location_id' => $hospital->location_id,
                'location_name' => $location ? $location->name : null,
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Error retrieving hospital details', 'error' => $e->getMessage()], 500);
        }
    }
}
