<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Datos del Vehículo</title>
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

        .form-group input {
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

        @media (max-width: 600px) {
            .form-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Datos del Vehículo</h1>

        <form action="{{ route('contrato.compra-venta.step1.post') }}" method="POST">
            @csrf

            <!-- Row 1: Marca / Modelo -->
            <div class="form-group">
                <div>
                    <!-- Marca Input with datalist -->
                    <input 
                        type="text" 
                        id="marca" 
                        name="marca" 
                        placeholder="Marca" 
                        list="brandDatalist" 
                        required 
                        autocomplete="off"
                    >
                    <!-- Datalist with all brand suggestions -->
                    <datalist id="brandDatalist"></datalist>
                </div>
                <div>
                    <!-- Modelo Input with datalist that will be populated dynamically -->
                    <input 
                        type="text" 
                        id="modelo" 
                        name="modelo" 
                        placeholder="Modelo" 
                        list="modelDatalist" 
                        required
                        autocomplete="off"
                    >
                    <datalist id="modelDatalist"></datalist>
                </div>
            </div>

            <!-- Row 2: Año / Color -->
            <div class="form-group">
                <div>
                    <input type="number" id="año" name="año" placeholder="Ano" required>
                </div>
                <div>
                    <input type="text" id="color" name="color" placeholder="Color" required>
                </div>
            </div>

            <!-- Row 3: Número de Chasis / Número de Motor -->
            <div class="form-group">
                <div>
                    <input 
                        type="text" 
                        id="numero_chasis" 
                        name="numero_chasis" 
                        placeholder="Número de Chasis" 
                        required
                    >
                </div>
                <div>
                    <input 
                        type="text" 
                        id="numero_motor" 
                        name="numero_motor" 
                        placeholder="Número de Motor" 
                        required
                    >
                </div>
            </div>

            <!-- Row 4: Número de Placa / Precio de Venta -->
            <div class="form-group">
                <div>
                    <input 
                        type="text" 
                        id="numero_placa" 
                        name="numero_placa" 
                        placeholder="Número de Placa" 
                        required
                    >
                </div>
                <div>
                    <input 
                        type="number" 
                        id="precio_venta" 
                        name="precio_venta" 
                        placeholder="Precio de Venta Acordado" 
                        required
                    >
                </div>
            </div>

            <!-- Buttons -->
            <div class="button-group">
                <a href="{{ route('seleccionar-contrato') }}" class="btn btn-back">Atrás</a>
                <button type="submit" class="btn btn-next">Siguiente</button>
            </div>
        </form>
    </div>

    <!-- JavaScript to Populate and Handle Brand/Model Logic -->
    <script>
        // 1) All possible brands
        const allBrands = [
          "Acura","Aiqar","Aiways","Alfa Romeo","Arcfox","Aston Martin","Audi","AVATR","Baic",
          "Bajaj","Baojun","BAW","Bentley","Bestune","BMW","Brilliance","Buick","BYD","Cadillac",
          "Cenntro","Chang LI","Changan","Chery","Chevrolet","Chrysler","Citroen","Daewoo","Daihatsu",
          "Dayun","Dongfeng","Faw","Ferrari","Fiat","Ford","Forthing","Foton","GAC","Geely","GMC",
          "Go Electric","Great Wall","GWM","Helmarv","Higer","Hino","Honda","Hummer","Hyundai",
          "Infiniti","Isuzu","Jac","Jaguar","Jeep","Jetour","JIM","Jin-Bei","Jingling","JMC","JMEV",
          "Kaiyi","Kaiyun","KGM","Kia","KYC","Lamborghini","Land Rover","Leapmotors","Lexus","Lincoln",
          "Maserati","Maxus","Mazda","McLaren","Mercedes-Benz","MG","Mini","Mitsubishi","Mullen",
          "Neta","Nissan","Ora","Peugeot","Porsche","Qingling","Radar","Ram","Renault","Riddara","Rivian",
          "Rolls Royce","Samsung","Seat","Shineray","Skywell","Smart","SsangYong","Subaru","Suzuki",
          "SWM","Tesla","Toyota","Volkswagen","Volvo","WULING","Xpeng","YEMA","Zeekr","ZXAUTO"
        ];

        // 2) Known brand -> model mappings (example)
        //    You can expand these lists as you want
        const brandModels = {
          "Toyota": ["Corolla", "Camry", "RAV4", "Yaris", "Hilux"],
          "Honda": ["Civic", "Accord", "CR-V", "City", "Pilot"],
          "Nissan": ["Sentra", "Altima", "Qashqai", "Navara", "Versa"],
          "Volkswagen": ["Golf", "Polo", "Tiguan", "Passat", "Jetta"],
          "Ford": ["Fiesta", "Focus", "Explorer", "Ranger", "Escape"],
          // ... Add more if you wish
        };

        // Populate the brand datalist with allBrands
        const brandDatalist = document.getElementById("brandDatalist");
        allBrands.forEach(brand => {
            const option = document.createElement("option");
            option.value = brand;
            brandDatalist.appendChild(option);
        });

        // On brand input change, fill the modelDatalist if brand matches brandModels
        const marcaInput = document.getElementById("marca");
        const modelDatalist = document.getElementById("modelDatalist");

        marcaInput.addEventListener("input", () => {
            const selectedBrand = marcaInput.value.trim();
            modelDatalist.innerHTML = ""; // clear old options

            // If brand is recognized, load the relevant models
            if (brandModels[selectedBrand]) {
                brandModels[selectedBrand].forEach(model => {
                    const opt = document.createElement("option");
                    opt.value = model;
                    modelDatalist.appendChild(opt);
                });
            } 
            // Otherwise, leave modelDatalist empty so user can type freely
        });
    </script>
</body>
</html>
