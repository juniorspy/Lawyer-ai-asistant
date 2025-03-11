<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Borrador del Contrato</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { background-color: #F4F4F4; font-family: Arial, sans-serif; padding: 30px; text-align: center; }
        .container { background: white; max-width: 800px; margin: auto; padding: 20px; border-radius: 6px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); text-align: left; }
        h1 { text-align: center; font-size: 1.8rem; color: #333; margin-bottom: 20px; }
        .contract-content { background: #FFF; padding: 20px; border-left: 2px solid #f25b00; border-right: 2px solid #f25b00; }
        textarea { width: 100%; min-height: 100px; padding: 8px; border-radius: 5px; border: 1px solid #ccc; font-size: 1rem; }
        .button-group { margin-top: 20px; display: flex; gap: 10px; }
        .btn { padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; font-size: 1rem; }
        .btn-back { background-color: #ccc; color: #333; text-decoration: none; }
        .btn-submit { background-color: #BFA37F; color: white; }
        .btn-submit:hover { background-color: #A7906F; }
        .alert { background-color: #dff0d8; color: #3c763d; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Borrador del Contrato</h1>

        <!-- Success message -->
        @if(session('status'))
            <div class="alert">
                {{ session('status') }}
            </div>
        @endif

        <!-- Section: Resumen de la Información -->
         <!-- <div class="section">
            <h2>Resumen de la Información</h2>
            <p><strong>Vehículo:</strong> {{ json_encode($vehicleData, JSON_PRETTY_PRINT) }}</p>
            <p><strong>Vendedor:</strong> {{ json_encode($sellerData, JSON_PRETTY_PRINT) }}</p>
            <p><strong>Comprador:</strong> {{ json_encode($buyerData, JSON_PRETTY_PRINT) }}</p>
            <p><strong>Contrato:</strong> {{ json_encode($contractData, JSON_PRETTY_PRINT) }}</p>
        </div> -->

        <!-- Section: Borrador Actual -->
        <div class="contract-content">
            {!! session('document_draft') !!}
        </div>

        <!-- Section: Feedback Form -->
        <form action="{{ route('contrato.compra-venta.step5.post') }}" method="POST">
            @csrf
            <!-- <h2>Solicitar Cambios / Retroalimentación</h2>-->
            <textarea name="feedback" placeholder="Escribe aquí tus cambios o sugerencias..."></textarea>
            <div class="button-group">
                <a href="{{ route('contrato.compra-venta.step4') }}" class="btn btn-back">Atrás</a>
                <button type="submit" class="btn btn-submit">Enviar Cambios a n8n</button>
            </div>
        </form>
    </div>
</body>
</html>