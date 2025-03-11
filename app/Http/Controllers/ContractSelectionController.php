<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContractSelectionController extends Controller
{
    public function redirect(Request $request)
    {
        $tipo = $request->input('tipoContrato');

        // If no selection, send user back with an error or default
        if (!$tipo) {
            return redirect()->route('seleccionar-contrato')->with('error', 'Debe seleccionar un tipo de contrato');
        }

        switch ($tipo) {
            case 'compra-venta-vehiculo':
                return redirect()->route('contrato.compra-venta.step1');
            case 'compra-venta-inmueble':
                // return redirect()->route('contrato.compra-venta-inmueble.step1');
                break;
            // ... other cases for "arrendamiento", "trabajo", etc.
            default:
                return redirect()->route('seleccionar-contrato')->with('error', 'Este contrato no está disponible aún.');
        }
    }
}
