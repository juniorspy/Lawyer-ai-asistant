<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Seleccione el Tipo de Contrato</title>
    <style>
        body {
            background-color: #F4F4F4;
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            max-width: 500px;
            margin: auto;
        }

        h1 {
            font-size: 1.8rem;
            color: #333;
        }

        select {
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }

        .continue-btn {
            margin-top: 20px;
            background-color: #BFA37F;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
        }

        .continue-btn:hover {
            background-color: #A7906F;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Seleccione el Tipo de Contrato</h1>

        <form action="{{ route('seleccionar-contrato.redirect') }}" method="GET">
    <label for="tipoContrato">Tipo de Contrato:</label>
    <select id="tipoContrato" name="tipoContrato" required>
        <option value="">Elija una opción</option>
        <option value="compra-venta-vehiculo">Contrato de Compra y Venta Vehículo</option>
        <option value="compra-venta-inmueble">Contrato de Compra y Venta Inmueble</option>
        <option value="arrendamiento">Contrato de Arrendamiento</option>
        <option value="trabajo">Contrato de Trabajo</option>
        <option value="servicios">Contrato de Servicios</option>
        <option value="obra">Contrato de Obra</option>
        <option value="sociedad">Contrato de Sociedad</option>
    </select>

    <button type="submit" class="continue-btn">Continuar</button>
</form>

    </div>
</body>
</html>
