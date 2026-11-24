<?php
namespace App\Http\Controllers;
use App\Models\Cliente;
use Illuminate\Http\Request;
class ClienteController extends Controller
{
    public function index()
    {
        return response()->json(Cliente::with('coches')->get());
    }
    public function store(Request $request)
    {
        $datos = $request->validate([
            'cedula' => 'required|unique:clientes,cedula',
            'direccion' => 'required',
            'telefono' => 'required'
        ]);
        $cliente = Cliente::create($datos);
        return response()->json($cliente, 201);
    }
    public function show($id)
    {
        return response()->json(Cliente::with('coches')->findOrFail($id));
    }
    public function update(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);
        $datos = $request->validate([
            'cedula' => 'required|unique:clientes,cedula,' . $id,
            'direccion' => 'required',
            'telefono' => 'required'
        ]);
        $cliente->update($datos);
        return response()->json($cliente);
    }
    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();
        return response()->json(['mensaje' => 'Cliente eliminado']);
    }
    public function coches($id)
    {
        $cliente = Cliente::findOrFail($id);
        return response()->json($cliente->coches);
    }
}
