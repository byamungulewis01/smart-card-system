<?php

namespace App\Http\Controllers;

use App\Http\Resources\AdmissionResource;
use App\Models\Admission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AdmissionController extends Controller
{
    //
    public function store_vital_signs(Request $request)
    {
        $signs = [
            'blood_pressure' => $request->blood_pressure,
            'temperature' => $request->temperature,
            'respiration' => $request->respiration,
        ];

        Admission::create([
            'card_id' => $request->id,
            'receptionist_id' => Auth::user()->id,
            'signs' => json_encode($signs),
        ]);

        return to_route('admission.receptionist_admissions');

    }
    public function receptionist_admissions()
    {
        $admissions = AdmissionResource::collection(Admission::where('receptionist_id', Auth::user()->id)->orderByDesc('id')->get());

        return Inertia::render('Hospital/ReceptionistAdmissions', compact('admissions'));
    }

    public function add_patient_data(Request $request)
    {
        $request->validate([
            'diagnosis' => 'required|string',
            'description' => 'required|string',
            'id' => 'required',
        ]);

        $admission = Admission::find($request->id);

        $data = [
            'diagnosis' => $request->diagnosis,
            'description' => $request->description,
        ];

        $admission->update([
            'nurse_id' => Auth::user()->id,
            'patient_data' => json_encode($data),
        ]);

        return to_route('admission.nurse_admissions');

    }
    public function nurse_admissions()
    {
        $admissions = AdmissionResource::collection(Admission::where('nurse_id', Auth::user()->id)->orderByDesc('id')->get());

        return Inertia::render('Hospital/NurseAdmissions', compact('admissions'));
    }

    public function add_price(Request $request)
    {
        $request->validate([
            'price' => 'required|integer|min:1',
            'id' => 'required',
        ]);

        $admission = Admission::find($request->id);
        $admission->update([
            'cashier_id' => Auth::user()->id,
            'price' => $request->price,
        ]);

        return to_route('admission.cashier_admissions');

    }

    public function cashier_admissions()
    {
        $admissions = AdmissionResource::collection(Admission::where('cashier_id', Auth::user()->id)->orderByDesc('id')->get());
        return Inertia::render('Hospital/CashierAdmissions', compact('admissions'));
    }
}
