<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Datos del Comprador</title>
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
        .radio-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .radio-group label {
            display: flex;
            align-items: center;
            gap: 5px;
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
        <h1>Datos del Comprador</h1>

        <form action="{{ route('contrato.compra-venta.step3.post') }}" method="POST">
            @csrf

            <!-- Row 1: Nombre / Apellidos -->
            <div class="form-group">
                <div>
                    <input type="text" id="comprador_nombre" name="comprador_nombre" placeholder="Nombre" required>
                </div>
                <div>
                    <input type="text" id="comprador_apellidos" name="comprador_apellidos" placeholder="Apellidos" required>
                </div>
            </div>

            <!-- Row 2: Cédula de Identidad -->
            <div class="form-group">
                <div style="width: 100%;">
                    <input type="text" id="comprador_cedula" name="comprador_cedula" placeholder="Cédula de Identidad" required>
                </div>
            </div>

            <!-- Row 3: Sexo -->
            <div class="radio-group">
                <label>
                    <input type="radio" name="comprador_sexo" value="Masculino" checked onchange="updateEstadoCivil()"> Masculino
                </label>
                <label>
                    <input type="radio" name="comprador_sexo" value="Femenino" onchange="updateEstadoCivil()"> Femenino
                </label>
            </div>

            <!-- Row 4: Domicilio -->
            <div class="form-group">
                <div style="width: 100%;">
                    <input type="text" id="comprador_domicilio" name="comprador_domicilio" placeholder="Domicilio" required>
                </div>
            </div>
           <!-- Row 6: Ciudad y País -->
            <div class="form-group">
                <div>
                    <input type="text" id="comprador_ciudad" name="comprador_ciudad" placeholder="Ciudad" required>
                </div>
                <div>
                    <input type="text" id="comprador_pais" name="comprador_pais" value="República Dominicana" required>
                </div>
            </div>

            <!-- Row 5: Estado Civil -->
            <div class="form-group">
                <div style="width: 100%;">
                    <select id="comprador_estado_civil" name="comprador_estado_civil" required>
                        <option value="Soltero">Soltero</option>
                        <option value="Casado">Casado</option>
                    </select>
                </div>
            </div>

            <!-- Custom Fields Section -->
            <div class="custom-fields-container">
                <p>Agregar Campo Personalizado (Comprador):</p>
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
                <a href="{{ route('contrato.compra-venta.step2') }}" class="btn btn-back">Atrás</a>
                <button type="submit" class="btn btn-next">Siguiente</button>
            </div>
        </form>
    </div>

    <!-- JavaScript for Estado Civil & Custom Fields -->
    <script>
        function updateEstadoCivil() {
            let sexo = document.querySelector('input[name="comprador_sexo"]:checked').value;
            let estadoCivilSelect = document.getElementById("comprador_estado_civil");
            estadoCivilSelect.innerHTML = "";
            if (sexo === "Masculino") {
                estadoCivilSelect.innerHTML += '<option value="Soltero">Soltero</option>';
                estadoCivilSelect.innerHTML += '<option value="Casado">Casado</option>';
            } else {
                estadoCivilSelect.innerHTML += '<option value="Soltera">Soltera</option>';
                estadoCivilSelect.innerHTML += '<option value="Casada">Casada</option>';
            }
        }

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
            
            // Create a span for the custom field label
            let fieldLabel = document.createElement("span");
            fieldLabel.textContent = fieldName + ":";
            fieldLabel.style.minWidth = "150px";
            fieldLabel.style.display = "inline-block";
            
            // Create the input element for the custom field's value
            let fieldInput = document.createElement("input");
            fieldInput.setAttribute("name", "custom_field_" + customFieldCount);
            fieldInput.setAttribute("placeholder", fieldName);
            fieldInput.required = true;

            // Create a remove button
            let removeBtn = document.createElement("button");
            removeBtn.setAttribute("type", "button");
            removeBtn.classList.add("remove-field-btn");
            removeBtn.textContent = "X";
            removeBtn.onclick = function() { newFieldDiv.remove(); };

            // Append label, input, and remove button to new div
            newFieldDiv.appendChild(fieldLabel);
            newFieldDiv.appendChild(fieldInput);
            newFieldDiv.appendChild(removeBtn);

            // Add the new div to the container
            container.appendChild(newFieldDiv);
            document.getElementById("customFieldNameInput").value = "";
        }

        // Initialize estado civil on load
        updateEstadoCivil();
    </script>
</body>
</html>
