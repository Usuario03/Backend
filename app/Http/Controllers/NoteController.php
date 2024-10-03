<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Note::all(); // Lista todas las notas
    }

    public function ordenarporfechadecreacion () 
    {
        return Note::orderBy('expiry_at', 'asc')->get();

    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $nota = Note::create($request->all());

        return response()->json($nota, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $nota = Note::find($id);

        if (!$nota) {
            return response()->json(['error' => 'Nota no encontrada'], 404);
        }

        return response()->json($nota);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $nota = Note::find($id);

        if (!$nota) {
            return response()->json(['error' => 'Nota no encontrada'], 404);
        }

        $request->validate([
            'titulo' => 'sometimes|string|max:255',
            'contenido' => 'sometimes|string',
        ]);

        $nota->update($request->all());

        return response()->json($nota);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $nota = Note::find($id);

        if (!$nota) {
            return response()->json(['error' => 'Nota no encontrada'], 404);
        }

        $nota->delete();

        return response()->json(['message' => 'Nota eliminada correctamente']);
    }
}
