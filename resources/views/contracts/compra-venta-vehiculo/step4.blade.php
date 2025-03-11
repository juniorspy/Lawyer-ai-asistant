<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Datos del Contrato</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            max-width: 600px;
            margin: auto;
        }
        h1 {
            font-size: 1.8rem;
            color: #333;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        .form-group {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 10px;
        }
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }
        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .btn {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
        }
        .btn-back {
            background-color: #ccc;
            color: #333;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .btn-next {
            background-color: #BFA37F;
            color: white;
        }
        .btn-next:hover {
            background-color: #A7906F;
        }
        .add-field-btn {
            background-color: #4CAF50;
            color: white;
            padding: 8px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
            width: 100%;
        }
        .remove-field-btn {
            background-color: #FF4C4C;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 5px;
        }
        .custom-fields-container {
            margin-top: 10px;
            text-align: left;
        }
        @media (max-width: 600px) {
            .form-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Datos del Contrato</h1>

        <!-- Note: The form posts to Step4.post, but the button says "Siguiente" -->
        <form action="{{ route('contrato.compra-venta.step4.post') }}" method="POST">
            @csrf
            <input type="hidden" name="session_id" value="{{ $sessionId }}">
            <!-- Row 1: Notario -->
            <div class="form-group">
                <div style="width: 100%;">
                    <label style="display:block; text-align:left; margin-bottom:5px;">Elija el notario para este contrato</label>
                    <select id="notario" name="notario" required>
                        <option value="">Seleccione Notario</option>
                        <option value="Notario 1">Notario 1</option>
                        <option value="Notario 2">Notario 2</option>
                        <option value="Notario 3">Notario 3</option>
                        <!-- Add more if needed -->
                    </select>
                </div>
            </div>

            <!-- Row 2: Fecha del contrato -->
            <div class="form-group">
                <div style="width: 100%;">
                    <label style="display:block; text-align:left; margin-bottom:5px;">Fecha del Contrato</label>
                    <input type="date" id="fecha_contrato" name="fecha_contrato" required>
                </div>
            </div>

            <!-- Row 3: Lugar (San Francisco de Macorís) -->
            <div class="form-group">
                <div style="width: 100%;">
                    <label style="display:block; text-align:left; margin-bottom:5px;">Lugar (Ciudad)</label>
                    <input type="text" id="lugar" name="lugar" placeholder="Ej: San Francisco de Macorís" required>
                </div>
            </div>

            <!-- Custom Fields Section -->
            <div class="custom-fields-container">
                <p>Agregar Campo Personalizado (Contrato):</p>
                <div class="form-group">
                    <input type="text" id="customFieldNameInput" placeholder="Ingrese nombre del campo">
                    <button type="button" class="add-field-btn" onclick="createCustomField()">Crear Campo</button>
                </div>
                <div id="customFields">
                    <!-- New custom fields will be added here -->
                </div>
            </div>

            <!-- Buttons -->
            <div class="button-group">
                <a href="{{ route('contrato.compra-venta.step3') }}" class="btn btn-back">Atrás</a>
                <button type="submit" class="btn btn-next">Siguiente</button>
            </div>
        </form>
    </div>

    <script>
        let customFieldCount = 0;
        function createCustomField() {
            let fieldName = document.getElementById("customFieldNameInput").value.trim();
            if (!fieldName) {
                alert("Por favor, ingrese el nombre del campo.");
                return;
            }
            customFieldCount++;
            let container = document.getElementById("customFields");
            let newFieldDiv = document.createElement("div");
            newFieldDiv.classList.add("form-group");

            // Create label text
            let fieldLabel = document.createElement("span");
            fieldLabel.textContent = fieldName + ":";
            fieldLabel.style.minWidth = "150px";
            fieldLabel.style.display = "inline-block";

            // Create the input
            let fieldInput = document.createElement("input");
            fieldInput.setAttribute("name", "custom_field_" + customFieldCount);
            fieldInput.setAttribute("placeholder", fieldName);
            fieldInput.required = true;

            // Create the remove button
            let removeBtn = document.createElement("button");
            removeBtn.setAttribute("type", "button");
            removeBtn.classList.add("remove-field-btn");
            removeBtn.textContent = "X";
            removeBtn.onclick = function() { newFieldDiv.remove(); };

            newFieldDiv.appendChild(fieldLabel);
            newFieldDiv.appendChild(fieldInput);
            newFieldDiv.appendChild(removeBtn);
            container.appendChild(newFieldDiv);

            document.getElementById("customFieldNameInput").value = "";
        }
    </script>
</body>
</html>
