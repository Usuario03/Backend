<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Histories;
use App\Models\User;

class HistoriesController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Obtiene todos los registros de historias médicas.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id)
    {
        $user = User::where('identification_number', $id)->value('id');
        $histories = Histories::with('patientOne', 'professionalOne')->where('professional_id', $user)->whereNull('deleted_at')->get();
        return response()->json($histories);
    }

    /**
     * Obtiene un registro de historia médica específico.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function historyPatient($id)
    {
        $user = User::where('identification_number', $id)->value('id');
        $histories = Histories::with('patientOne', 'professionalOne')->where('patient_id', $user)->whereNull('deleted_at')->get();
        return response()->json($histories);
    }

    /**
     * Crea un nuevo registro de historia médica.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:users,id', // Clave foránea para el paciente
            'patient_info' => 'required|string',
            'date_time' => 'required|date',
            'patient_status' => 'nullable|string',
            'medical_history' => 'nullable|string',
            'final_evolution' => 'nullable|string',
            'professional_concept' => 'nullable|string',
            'recommendations' => 'nullable|string',
        ]);

        $consecutive_number = Histories::where('patient_id', $request->input('patient_id'))->whereNull('deleted_at')->value('consecutive_number');
        $consecutive_number = $consecutive_number ? $consecutive_number + 1 : 1;

        $history = new Histories();
        $history->patient_id = $request->input('patient_id');
        $history->professional_id = auth()->user()->id;
        $history->patient_info = $request->input('patient_info');
        $history->date_time = $request->input('date_time');
        $history->consecutive_number = $consecutive_number;
        $history->patient_status = $request->input('patient_status');
        $history->medical_history = $request->input('medical_history');
        $history->final_evolution = $request->input('final_evolution');
        $history->professional_concept = $request->input('professional_concept');
        $history->recommendations = $request->input('recommendations');
        $history->assistance = false;
        $history->save();

        return response()->json(['message' => 'Historia médica creada correctamente'], 201);
    }

    public function confirmAssistance($id)
    {
        $history = Histories::where('id', $id)->where('assistance', false)->whereNull('deleted_at')->first();
        if (!$history) {
            return response()->json(['message' => 'Esta historia ya fue confirmada o no existe'], 404);
        }
        $history->assistance = true;
        $history->save();
        return response()->json(['message' => 'Historia medica confirmada correctamente'], 200);
    }
    /**
     * Obtiene un registro de historia médica específico.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $history = Histories::with('patientOne', 'professionalOne')->where('id', $id)->whereNull('deleted_at')->first();
        if (!$history) {
            return response()->json(['message' => 'Historia médica no encontrada'], 404);
        }
        return response()->json($history);
    }

    /**
     * Actualiza un registro de historia médica existente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $history = Histories::where('id', $id)->whereNull('deleted_at')->first();
        if (!$history) {
            return response()->json(['message' => 'Historia médica no encontrada'], 404);
        }

        $request->validate([
            'patient_id' => 'required|exists:users,id',
            'professional_id' => 'required|exists:users,id',
            'patient_info' => 'required|string',
            'date_time' => 'required|date',
            'consecutive_number' => 'required|integer',
            'patient_status' => 'nullable|string',
            'medical_history' => 'nullable|string',
            'final_evolution' => 'nullable|string',
            'professional_concept' => 'nullable|string',
            'recommendations' => 'nullable|string',
        ]);

        $history->update($request->all());
        return response()->json(['message' => 'Historia médica actualizada correctamente'], 200);
    }

    /**
     * Elimina un registro de historia médica.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $history = Histories::where('id', $id)->whereNull('deleted_at')->first();
        if (!$history) {
            return response()->json(['message' => 'Historia médica no encontrada'], 404);
        }
        $history->deleted_at = now();
        $history->save();
        return response()->json(['message' => 'Historia médica eliminada correctamente']);
    }
}
