<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Como te puedo ayudar</title>
    <style>
        /* General reset/normalization (optional) */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #F4F4F4;  /* Light gray bg */
            font-family: Arial, sans-serif;
            color: #50555C; /* A subtle dark gray for text */
        }

        .section-title {
            text-align: center;
            font-size: 2rem;
            font-weight: 600;
            margin-top: 50px;
            margin-bottom: 30px;
        }

        .cards-container {
            display: flex;
            justify-content: space-around;  /* space between cards horizontally */
            align-items: flex-start;
            max-width: 1200px; /* limit row width */
            margin: 0 auto;    /* center horizontally */
            padding: 20px;
        }

        .card {
            background-color: #FFFFFF; /* white card */
            width: 300px;
            border-radius: 6px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            padding: 20px;
            text-align: center;
            margin: 10px;
        }

        .card h3 {
            font-size: 1.25rem;
            margin-bottom: 10px;
        }

        .card p {
            font-size: 0.95rem;
            line-height: 1.4;
            color: #50555C;
            margin-bottom: 20px;
        }

        .card button {
            background-color: #BFA37F; /* adjust to your desired “gold” tone */
            border: none;
            border-radius: 4px;
            color: #FFFFFF;
            font-size: 1rem;
            padding: 10px 15px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px; /* space between icon and text */
        }

        /* Example icon styles (if using Font Awesome or similar) */
        .card button i {
            font-size: 1.2rem;
        }

        .card button:hover {
            background-color: #A7906F; /* slightly darker hover effect */
        }

        /* Responsive tweak for smaller screens */
        @media (max-width: 768px) {
            .cards-container {
                flex-direction: column;
                align-items: center;
            }

            .card {
                width: 90%;
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Título principal -->
    <h1 class="section-title">Como te puedo ayudar</h1>

    <!-- Contenedor de Tarjetas -->
    <div class="cards-container">
        
        <!-- Tarjeta 1: Redacción -->
        <div class="card">
            <h3>Redacción</h3>
            <p>
                Generación de borradores: capacidad para elaborar borradores de contratos, demandas, testamentos y otros documentos legales basados en plantillas y datos específicos. Revisión y corrección de documentos.
            </p>
            <a href="{{ route('seleccionar-contrato') }}">
            <button>
                <!-- Icono (ej. Font Awesome) -->
                <i class="fas fa-file-alt"></i>
                Redactar Contrato
            </button></a>
        </div>

        <!-- Tarjeta 2: Investigación legal -->
        <div class="card">
            <h3>Investigación legal</h3>
            <p>
                Permite buscar y analizar legislación, jurisprudencia y doctrina relevante, facilitando la obtención de información actualizada y el respaldo en casos concretos.
            </p>
            <button>
                <!-- Icono (ej. Font Awesome) -->
                <i class="fas fa-search"></i>
                Investigación legal
            </button>
        </div>

        <!-- Tarjeta 3: Plantillas Jurídicas -->
        <div class="card">
            <h3>Plantillas Jurídicas</h3>
            <p>
                Ofrece una variedad de modelos y formatos preestablecidos para documentos legales, adaptados a las normativas vigentes y a las necesidades específicas de cada caso.
            </p>
            <button>
                <i class="fas fa-file-invoice"></i>
                Plantillas jurídicas
            </button>
        </div>

    </div>

    <!-- Ejemplo: Carga de Font Awesome (opcional, si usas esos iconos) -->
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>
</body>
</html>
