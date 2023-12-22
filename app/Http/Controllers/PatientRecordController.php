<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Hospital;
use App\Models\Disease;
use App\Models\Location;
use App\Models\PatientRecord;


class PatientRecordController extends Controller
{
    public function register(Request $request)
    {
        try {
            $request->validate([
                'patient_id' => 'required|integer',
                'hospital_id' => 'required|integer',
                'disease_id' => 'required|integer',
            ]);
            $admitted = !empty($request->input('admitted')) ? date('Y-m-d H:i:s',strtotime($request->input('admitted'))) :date('Y-m-d H:i:s') ;
            $discharged = !empty($request->input('discharged')) ? date('Y-m-d H:i:s',strtotime($request->input('discharged'))) :NULL ;

            $patient = PatientRecord::create([
                'patient_id' => $request->input('patient_id'),
                'hospital_id' => $request->input('hospital_id'),
                'disease_id' => $request->input('disease_id'),
                'admitted' => $admitted,
                'discharged' => $discharged
            ]);

            return response()->json(['message' => 'Patient record registered successfully', 'data' => $patient], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error registering patient record', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try{
            $request->validate([
                'patient_id' => 'required|integer',
                'hospital_id' => 'required|integer',
                'disease_id' => 'required|integer',
            ]);
            $admitted = !empty($request->input('admitted')) ? date('Y-m-d H:i:s',strtotime($request->input('admitted'))) :date('Y-m-d H:i:s') ;
            $discharged = !empty($request->input('discharged')) ? date('Y-m-d H:i:s',strtotime($request->input('discharged'))) :NULL ;

            $patient = PatientRecord::findOrFail($id);

            $patient->update([
                'patient_id' => $request->input('patient_id'),
                'hospital_id' => $request->input('hospital_id'),
                'disease_id' => $request->input('disease_id'),
                'admitted' => $admitted,
                'discharged' => $discharged,
            ]);

            return response()->json(['message' => 'Patient record updated successfully', 'data' => $patient], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error registering Patient record', 'error' => $e->getMessage()], 500);
        }
    }

    public function getPatientRecords(Request $request)
    {
        try {
            $query = PatientRecord::with(['patient', 'hospital', 'disease']);

            if ($request->has('patient_name') && !empty($request->input('patient_name'))) {
                $query->whereHas('patient', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->input('patient_name') . '%');
                });
            }

            if ($request->has('hospital_name') && !empty($request->input('hospital_name'))) {
                $query->whereHas('hospital', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->input('hospital_name') . '%');
                });
            }

            if ($request->has('admitted') && !empty($request->input('admitted'))) {
                $admitted = date('Y-m-d',strtotime($request->input('admitted')));
                $query->where('admitted', 'like', '%' . $admitted . '%');
            }

            if ($request->has('disease_name') && !empty($request->input('disease_name'))) {
                $query->whereHas('disease', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->input('disease_name') . '%');
                });
            }

            if ($request->has('discharged') && !empty($request->input('discharged'))) {
                $discharged = date('Y-m-d',strtotime($request->input('discharged')));
                $query->where('discharged', 'like', '%' . $discharged . '%');
            }

            $patientRecords = $query->get();

            $patientRecordsCount = $query->count();

            return response()->json([
                'patient_records' => $patientRecords,
                'patient_records_count' => $patientRecordsCount,
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Error retrieving patient records', 'error' => $e->getMessage()], 500);
        }
    }

}
