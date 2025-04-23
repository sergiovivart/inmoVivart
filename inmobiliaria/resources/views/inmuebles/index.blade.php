<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Propiedades</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light p-4">

    <div class="container">
        <h3>Propiedades</h3>
    </div>

    <div id="inmuebles" class="container">

        @foreach ($propiedades as $propiedad)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $propiedad->nombre }}</h5>
                    <p class="card-text">Descripción: {{ $propiedad->descripcion }}</p>
                    <p class="card-text">Precio: {{ $propiedad->precio }}</p>
                    <p class="card-text">Ubicación:
                        <span>{{ $propiedad->provincia->nombre ?? 'Sin provincia' }}</span>
                    </p>
                </div>
            </div>
        @endforeach


        <!-- Bootstrap JS (opcional) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
