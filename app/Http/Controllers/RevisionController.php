<?php
namespace App\Http\Controllers;
use App\Models\Revision;
use Illuminate\Http\Request;
class RevisionController extends Controller
{
    public function index()
    {
        return response()->json(Revision::with('coche')->get(), 200);
    }
    public function store(Request $request)
    {
        $datos = $request->validate([
            'codigo' => 'required|unique:revisiones,codigo',
            'aceite' => 'required|boolean',
            'filtro' => 'required|boolean',
            'frenos' => 'required|boolean',
            'coche_id' => 'required|exists:coches,id'
        ]);

        $revision = Revision::create($datos);
        return response()->json($revision, 201);
    }
    public function show($id)
    {
        $revision = Revision::find($id);
        if (!$revision) {
            return response()->json(['mensaje' => 'Revision no encontrada'], 404);
        }
        return response()->json($revision, 200);
    }
    public function update(Request $request, $id)
    {
        $revision = Revision::find($id);
        if (!$revision) {
            return response()->json(['mensaje' => 'Revision no encontrada'], 404);
        }
        $datos = $request->validate([
            'codigo' => 'required|unique:revisiones,codigo,' . $id,
            'aceite' => 'required|boolean',
            'filtro' => 'required|boolean',
            'frenos' => 'required|boolean',
            'coche_id' => 'required|exists:coches,id'
        ]);
        $revision->update($datos);
        return response()->json($revision->fresh(), 200);
    }
    public function destroy($id)
    {
        $revision = Revision::find($id);
        if (!$revision) {
            return response()->json(['mensaje' => 'Revision no encontrada'], 404);
        }
        $revision->delete();
        return response()->json(['mensaje' => 'Revision eliminada'], 200);
    }
    public function historial($id)
    {
        return response()->json(
            Revision::where('coche_id', $id)->get(),
            200
        );
    }
}
