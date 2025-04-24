<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Propiedades</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light p-4">

    <style>
        .card-image img {
            width: 90%;
            height: 200px;
            object-fit: cover;
            border-radius: 0.25rem;
            margin-bottom: 1rem;
        }
    </style>

    <div class="container">
        <h3>Propiedades</h3>
    </div>

    <!-- filepath: c:\Users\purpleflame\Desktop\DEV\inmoVivart\inmobiliaria\resources\views\inmuebles\index.blade.php -->
    <div class="container mb-4">
        <form action="{{ route('inmuebles.index') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <label for="provincia" class="form-label">Provincia</label>
                <select name="provincia_id" id="provincia" class="form-select">
                    <option value="">Todas las provincias</option>
                    @foreach ($provincias as $provincia)
                        <option value="{{ $provincia->id }}"
                            {{ request('provincia_id') == $provincia->id ? 'selected' : '' }}>
                            {{ $provincia->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="ciudad" class="form-label">Ciudad</label>
                <select name="ciudad_id" id="ciudad" class="form-select">
                    <option value="">Todas las ciudades</option>
                    @foreach ($ciudades as $ciudad)
                        <option value="{{ $ciudad->id }}" {{ request('ciudad_id') == $ciudad->id ? 'selected' : '' }}>
                            {{ $ciudad->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Filtrar</button>
            </div>
        </form>
    </div>



    <div id="inmuebles" class="container">
        <div class="row">
            @foreach ($propiedades as $propiedad)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">

                            <div class="card-image">
                                <img src="/imagenes/{{ $propiedad->referencia_interna }}/foto.jpg" alt="imagenPropiedad"
                                    class="img-fluid">
                            </div>
                            <h5 class="card-title">{{ $propiedad->nombre }}</h5>
                            <p class="card-text">Descripción: {{ $propiedad->descripcion }}</p>
                            <p class="card-text">Precio: {{ $propiedad->precio }}</p>
                            <p class="card-text">Ubicación:
                                <span>{{ $propiedad->provincia->nombre ?? 'Sin provincia' }}</span>
                                <span> - </span>
                                <span>{{ $propiedad->city->nombre ?? 'Sin ciudad' }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Bootstrap JS (opcional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
