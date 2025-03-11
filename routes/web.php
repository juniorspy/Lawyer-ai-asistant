<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file defines the complete multi-step flow for the "Compra y Venta
| de Vehículo" contract process. Data is collected in steps and stored in the
| Laravel session. In Step 4, all data is merged and used to generate a contract
| draft locally using a pre-made template. That draft is then displayed in Step 5,
| where the lawyer can provide feedback. If feedback is submitted, it is sent to
| n8n to update the draft.
|
*/

// 1) Home Page
Route::get('/', function () {
    return view('home');
})->name('home');

// 2) Contract Selection Page
Route::get('/seleccionar-contrato', function () {
    return view('seleccionar-contrato');
})->name('seleccionar-contrato');

// 3) Handle Contract Selection & Redirect
Route::get('/seleccionar-contrato/redirect', function (Request $request) {
    $tipo = $request->input('tipoContrato');

    if (!$tipo) {
        return redirect()->route('seleccionar-contrato')
                         ->with('error', 'Debe seleccionar un tipo de contrato');
    }

    // Store the selected contract type in the session
    session(['contract_type' => $tipo]);

    switch ($tipo) {
        case 'compra-venta-vehiculo':
            return redirect()->route('contrato.compra-venta.step1');
        default:
            return redirect()->route('seleccionar-contrato')
                             ->with('error', 'Este contrato no está disponible aún.');
    }
})->name('seleccionar-contrato.redirect');

// 4) Step 1 (Datos del Vehículo)
Route::get('/contrato/compra-venta-vehiculo/step1', function () {
    return view('contracts.compra-venta-vehiculo.step1');
})->name('contrato.compra-venta.step1');

// 5) Handle Step 1 -> Step 2
Route::post('/contrato/compra-venta-vehiculo/step2', function (Request $request) {
    session(['vehicle_data' => $request->except('_token')]);
    return redirect()->route('contrato.compra-venta.step2');
})->name('contrato.compra-venta.step1.post');

// 6) Step 2 (Datos del Vendedor)
Route::get('/contrato/compra-venta-vehiculo/step2', function () {
    return view('contracts.compra-venta-vehiculo.step2');
})->name('contrato.compra-venta.step2');

// 7) Handle Step 2 -> Step 3
Route::post('/contrato/compra-venta-vehiculo/step3', function (Request $request) {
    session(['seller_data' => $request->except('_token')]);
    return redirect()->route('contrato.compra-venta.step3');
})->name('contrato.compra-venta.step2.post');

// 8) Step 3 (Datos del Comprador)
Route::get('/contrato/compra-venta-vehiculo/step3', function () {
    return view('contracts.compra-venta-vehiculo.step3');
})->name('contrato.compra-venta.step3');

// 9) Handle Step 3 -> Step 4
Route::post('/contrato/compra-venta-vehiculo/step4', function (Request $request) {
    session(['buyer_data' => $request->except('_token')]);
    return redirect()->route('contrato.compra-venta.step4');
})->name('contrato.compra-venta.step3.post');

// 10) Step 4 (Datos del Contrato) - GET
Route::get('/contrato/compra-venta-vehiculo/step4', function () {
    return view('contracts.compra-venta-vehiculo.step4', [
        'sessionId'    => session()->getId(),
        'vehicleData'  => session('vehicle_data', []),
        'sellerData'   => session('seller_data', []),
        'buyerData'    => session('buyer_data', []),
        'contractData' => session('contract_data', [])
    ]);
})->name('contrato.compra-venta.step4');

// 11) Step 4 (POST) - Generate the Contract Draft Locally Using the Template
Route::post('/contrato/compra-venta-vehiculo/step4/save', function (Request $request) {
    // Save Step 4 (contract) data in session
    session(['contract_data' => $request->except('_token')]);

    // Retrieve data from previous steps
    $vehicleData  = session('vehicle_data', []);
    $sellerData   = session('seller_data', []);
    $buyerData    = session('buyer_data', []);
    $contractData = session('contract_data', []);

    // Load the pre-made contract template from a file
    $template = file_get_contents(resource_path('views/contracts/template.html'));

    // Parse date to extract day, month, year
    $fechaContrato = isset($contractData['fecha_contrato']) ? explode('-', $contractData['fecha_contrato']) : ['', '', ''];
    $anioFirma = $fechaContrato[0] ?? '';
    $mesFirma = $fechaContrato[1] ?? '';
    $diaFirma = $fechaContrato[2] ?? '';
    
    // Convert month number to name
    $mesesEnEspanol = [
        '01' => 'enero', '02' => 'febrero', '03' => 'marzo', '04' => 'abril',
        '05' => 'mayo', '06' => 'junio', '07' => 'julio', '08' => 'agosto',
        '09' => 'septiembre', '10' => 'octubre', '11' => 'noviembre', '12' => 'diciembre'
    ];
    $mesFirma = isset($mesesEnEspanol[$mesFirma]) ? $mesesEnEspanol[$mesFirma] : $mesFirma;

    // Prepare seller full name
    $vendedorNombreCompleto = trim(($sellerData['nombre'] ?? '') . ' ' . ($sellerData['apellidos'] ?? ''));
    
    // Prepare buyer full name
    $compradorNombreCompleto = trim(($buyerData['comprador_nombre'] ?? '') . ' ' . ($buyerData['comprador_apellidos'] ?? ''));
    
    // Determine gender-specific text based on sexo values
    $vendedorEsMasculino = strtolower($sellerData['sexo'] ?? '') === 'masculino';
    $compradorEsMasculino = strtolower($buyerData['comprador_sexo'] ?? '') === 'masculino';
    
    // Gender-specific references
    $vendedorSaludo = $vendedorEsMasculino ? 'el señor' : 'la señora';
    $vendedorSuffix = $vendedorEsMasculino ? '' : 'a';
    $vendedorTitulo = $vendedorEsMasculino ? 'Vendedor' : 'Vendedora';
    $vendedorArticulo = $vendedorEsMasculino ? 'EL' : 'LA';
    
    $compradorSaludo = $compradorEsMasculino ? 'el señor' : 'la señora';
    $compradorSuffix = $compradorEsMasculino ? '' : 'a';
    $compradorTitulo = $compradorEsMasculino ? 'Comprador' : 'Compradora';
    $compradorArticulo = $compradorEsMasculino ? 'EL' : 'LA';

    // Generate the contract by replacing placeholders with session data
    $generatedContract = str_replace(
        [
            '{{vendedor_saludo}}', '{{vendedor_nombre}}', '{{vendedor_cedula}}', '{{vendedor_estado_civil}}',
            '{{vendedor_direccion}}', '{{vendedor_municipio}}', '{{vendedor_ciudad}}', '{{vendedor_pais}}', '{{vendedor_suffix}}', '{{vendedor_titulo}}',
            '{{vendedor_articulo}}',
    
            '{{comprador_saludo}}', '{{comprador_nombre}}', '{{comprador_cedula}}', '{{comprador_estado_civil}}',
            '{{comprador_direccion}}', '{{comprador_municipio}}', '{{comprador_ciudad}}', '{{comprador_pais}}', '{{comprador_suffix}}', '{{comprador_titulo}}',
            '{{comprador_articulo}}',
    
            '{{vehiculo_marca}}', '{{vehiculo_modelo}}', '{{vehiculo_color}}', '{{vehiculo_chasis}}',
            '{{vehiculo_motor}}', '{{vehiculo_placa}}', '{{vehiculo_anio}}', '{{precio_venta}}', '{{forma_pago}}',
            '{{ciudad_firma}}', '{{lugar_firma}}', '{{dia_firma}}', '{{mes_firma}}', '{{anio_firma}}'
        ],
        [
            // Seller values
            $vendedorSaludo,
            $vendedorNombreCompleto,
            $sellerData['cedula'] ?? 'N/A',
            $sellerData['estado_civil'] ?? 'N/A',
            $sellerData['domicilio'] ?? 'N/A',
            $sellerData['domicilio'] ?? 'N/A', // using domicilio as municipio
            $sellerData['vendedor_ciudad'] ?? 'N/A', // updated key for seller city
            $sellerData['vendedor_pais'] ?? 'República Dominicana', // updated key for seller country
            $vendedorSuffix,
            $vendedorTitulo,
            $vendedorArticulo,
    
            // Buyer values
            $compradorSaludo,
            $compradorNombreCompleto,
            $buyerData['comprador_cedula'] ?? 'N/A',
            $buyerData['comprador_estado_civil'] ?? 'N/A',
            $buyerData['comprador_domicilio'] ?? 'N/A',
            $buyerData['comprador_domicilio'] ?? 'N/A', // using domicilio as municipio
            $buyerData['comprador_ciudad'] ?? 'N/A', // updated key for buyer city
            $buyerData['comprador_pais'] ?? 'República Dominicana', // updated key for buyer country
            $compradorSuffix,
            $compradorTitulo,
            $compradorArticulo,
    
            // Vehicle values
            $vehicleData['marca'] ?? 'N/A',
            $vehicleData['modelo'] ?? 'N/A',
            $vehicleData['color'] ?? 'N/A',
            $vehicleData['numero_chasis'] ?? 'N/A',
            $vehicleData['numero_motor'] ?? 'N/A',
            $vehicleData['numero_placa'] ?? 'N/A',
            $vehicleData['año'] ?? $vehicleData['anio'] ?? $vehicleData['a\u00f1o'] ?? 'N/A',
            $vehicleData['precio_venta'] ?? 'N/A',
            $contractData['forma_pago'] ?? 'Efectivo',
            $contractData['lugar'] ?? 'N/A', // for {{ciudad_firma}}
            $contractData['lugar'] ?? 'N/A', // for {{lugar_firma}}
            $diaFirma,
            $mesFirma,
            $anioFirma
        ],
        $template
    );
    
    

    // Store the generated contract in session
    session(['document_draft' => $generatedContract]);

    return redirect()->route('contrato.compra-venta.step5')
                     ->with('status', 'Borrador generado correctamente.');
})->name('contrato.compra-venta.step4.post');
// 12) Step 5 (Borrador del Contrato) - GET: Display the Generated Contract from the Template
Route::get('/contrato/compra-venta-vehiculo/step5', function () {
    // Debugging: Log session data
    \Log::info('Session Data:', [
        'vehicleData' => session('vehicle_data', []),
        'sellerData' => session('seller_data', []),
        'buyerData' => session('buyer_data', []),
        'contractData' => session('contract_data', []),
        'documentDraft' => session('document_draft', null)
    ]);
    return view('contracts.compra-venta-vehiculo.step5', [
        'vehicleData'   => session('vehicle_data', []),
        'sellerData'    => session('seller_data', []),
        'buyerData'     => session('buyer_data', []),
        'contractData'  => session('contract_data', []),
        'documentDraft' => session('document_draft', null)
    ]);
})->name('contrato.compra-venta.step5');

// 13) Step 5 (POST) - Send Feedback to n8n for AI Processing (Only if User Requests Changes)
Route::post('/contrato/compra-venta-vehiculo/step5', function (Request $request) {
    $feedback = $request->input('feedback', 'No feedback provided');

    // Merge session data to send along with feedback
    $data = [
        'contract_type'  => session('contract_type', 'unknown'),
        'vehicle_data'   => session('vehicle_data', []),
        'seller_data'    => session('seller_data', []),
        'buyer_data'     => session('buyer_data', []),
        'contract_data'  => session('contract_data', []),
        'document_draft' => session('document_draft', ''),
        'user_feedback'  => $feedback
    ];

    // Send feedback to n8n for AI processing
    $response = Http::post('https://automations.onrpa.com/webhook/Asistente-abogado', $data);

    // Update the contract draft with AI feedback
    session(['document_draft' => $response->body()]);

    return redirect()->route('contrato.compra-venta.step5')
                     ->with('status', 'Borrador actualizado correctamente.');
})->name('contrato.compra-venta.step5.post');
