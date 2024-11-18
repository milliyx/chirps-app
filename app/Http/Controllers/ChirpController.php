<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // Añadir esta línea

class ChirpController extends Controller
{
    use AuthorizesRequests; // Usar este trait

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtén todos los chirps más recientes con su relación 'user' cargada
        $chirps = Chirp::with('user')->latest()->get();

        return view('chirps.index', ['chirps' => $chirps]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Valida la entrada del usuario
        $validated = $request->validate([
            'message' => ['required', 'min:3', 'max:255'],
        ]);

        // Crea un chirp asociado al usuario autenticado
        auth()->user()->chirps()->create($validated);

        // Redirige al listado de chirps con un mensaje de éxito
        return to_route('chirps.index')->with('status', __('Chirp published!'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp)
    {
       
        $this->authorize('update', $chirp);

        return view('chirps.edit', ['chirp' => $chirp]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp)
    {
        $this->authorize('update', $chirp);


        $validated = $request->validate([
            'message' => ['required', 'min:3', 'max:255'],
        ]);

        // Actualiza el mensaje
        $chirp->update($validated);

        // Redirige al listado de chirps con un mensaje de éxito
        return to_route('chirps.index')->with('status', __('Chirp updated!'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp)
    {
        $this->authorize('delete', $chirp);

        $chirp->delete();

        // Redirige al listado con un mensaje de éxito
        return to_route('chirps.index')->with('status', __('Chirp deleted!'));
    }
}
