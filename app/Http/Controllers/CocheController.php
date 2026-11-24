<?php
namespace App\Http\Controllers;

use App\Models\Coche;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CocheController extends Controller
{
    public function index()
    {
        return response()->json(Coche::with('cliente')->get());
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'marca' => 'required',
            'modelo' => 'required',
            'color' => 'required',
            'precio' => 'required|numeric|min:0',
            'cliente_id' => 'required|exists:clientes,id',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        if ($request->hasFile('foto')) {
            $datos['foto'] = $request->file('foto')->store('coches', 'public');
        }

        $coche = Coche::create($datos);

        return response()->json($coche, 201);
    }

    public function show($id)
    {
        return response()->json(
            Coche::with(['cliente', 'revisiones'])->findOrFail($id)
        );
    }

    public function update(Request $request, $id)
    {
        $coche = Coche::findOrFail($id);

        $datos = $request->validate([
            'marca' => 'required',
            'modelo' => 'required',
            'color' => 'required',
            'precio' => 'required|numeric|min:0',
            'cliente_id' => 'required|exists:clientes,id',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        if ($request->hasFile('foto')) {
            if ($coche->foto) {
                Storage::disk('public')->delete($coche->foto);
            }

            $datos['foto'] = $request->file('foto')->store('coches', 'public');
        }

        $coche->update($datos);

        return response()->json($coche);
    }

    public function destroy($id)
    {
        $coche = Coche::findOrFail($id);

        if ($coche->foto) {
            Storage::disk('public')->delete($coche->foto);
        }

        $coche->delete();

        return response()->json(['mensaje' => 'Coche eliminado']);
    }

    public function conRevisiones()
    {
        return response()->json(
            Coche::with('revisiones')->has('revisiones')->get()
        );
    }
}
