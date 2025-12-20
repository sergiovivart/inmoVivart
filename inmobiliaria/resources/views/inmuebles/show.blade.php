<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Propiedades</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light p-4">

    <style>
        .card-image {
            text-align: center;
        }

        .card-image img {
            width: 100%;
            height: 500px;
            object-fit: cover;
            border-radius: 0.25rem;
            margin-bottom: 1rem;
        }
    </style>

    <div class="container">
        <h3 class="text-center">propiedad</h3>
    </div>

    <!-- filepath: c:\Users\purpleflame\Desktop\DEV\inmoVivart\inmobiliaria\resources\views\inmuebles\index.blade.php -->

    <div id="inmuebles" class="container">
        <div class="row">
            <div class="card">
                <div class="card-body">

                    <div class="card-image">
                        <img src="{{ asset('storage/imagenes/' . $propiedad->referencia_interna . '/foto.jpg') }}"
                            alt="imagenPropiedad" class="img-fluid">
                    </div>
                    <h5 class="card-title">{{ $propiedad->nombre }}</h5>

                    <p class="card-text">
                        {{ number_format($propiedad->precio, 0, ',', '.') }} €
                    </p>

                    <p class="card-text descripcion-corta">
                        {{ $propiedad->descripcion }}
                    </p>


                    <p class="card-text text-muted">
                        <span class="me-1">📍</span>
                        <span>{{ $propiedad->provincia->nombre ?? 'Sin provincia' }}</span>
                        <span> - </span>
                        <span>{{ $propiedad->city->nombre ?? 'Sin ciudad' }}</span>
                    </p>


                    <p class="card-text">
                        <span class="me-4">📐 {{ $propiedad->superficie }} m²</span>
                        <span class="me-4">🛏️ {{ $propiedad->habitaciones }} habitaciones</span>
                        <span>🚿 {{ $propiedad->baños }} baños</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (opcional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
