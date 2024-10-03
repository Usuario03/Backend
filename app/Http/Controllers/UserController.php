<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
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
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::where('identification_number', $id)->first();
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
        $userDetails = [
            'id' => $user->id,
            'identification_number' => $user->identification_number,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'phone_number' => $user->phone_number,
            'location' => $user->location,
            'email_verified_at' => $user->email_verified_at,
            'type' => $user->type,
        ];
        return response()->json($userDetails);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $user = User::where('id', $id)->first();
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
        $request->validate([
            'identification_number' => 'required|string|max:100',
            'first_name' => 'required|max:100|',
            'last_name' => 'required|max:100|',
            'email' => 'required|string|email|max:100',
            'phone_number' => 'required|max:100|',
            'location' => 'required|max:100|',
            'password' => 'required|string|min:6',
            'type' => 'required|integer|max:2',
        ]);
        $user->update([
            'identification_number' => $request->input('identification_number'),
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone_number'),
            'location' => $request->input('location'),
            'password' => bcrypt($request->input('password')),
            'type' => $request->input('type'),
        ]);
        return response()->json(['message' => 'Usuario actualizado correctamente', 'status' => 200], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
