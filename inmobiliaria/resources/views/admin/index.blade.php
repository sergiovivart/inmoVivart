<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Propiedades</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light p-4">
    <div class="container">
        <h2 class="mb-4">Crear Propiedad</h2>

        <form action="{{ route('admin.inmuebles.create') }}" method="POST">
            @csrf

            <div class="row mb-3">
                <div class="col">
                    <label>Referencia Interna</label>
                    <input type="text" name="referencia_interna" class="form-control" required>
                </div>
                <div class="col">
                    <label>Nombre</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>
            </div>

            <div class="mb-3">
                <label>Descripción</label>
                <textarea name="descripcion" class="form-control" rows="3"></textarea>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label>Precio</label>
                    <input type="number" name="precio" step="0.01" class="form-control" required>
                </div>
                <div class="col">
                    <label>Superficie (m²)</label>
                    <input type="number" name="superficie" class="form-control" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label>Habitaciones</label>
                    <input type="number" name="habitaciones" class="form-control" required>
                </div>
                <div class="col">
                    <label>Baños</label>
                    <input type="number" name="baños" class="form-control" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label>Provincia</label>
                    <select name="provincia_id" id="provincia" class="form-select" required>
                        <option value="">Seleccione</option>
                        @foreach ($provincias as $provincia)
                            <option value="{{ $provincia->id }}">{{ $provincia->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label>Ciudad</label>
                    <select name="ciudad_id" id="ciudad" class="form-select" required>
                        <option value="">Seleccione provincia primero</option>
                        @foreach ($ciudades as $ciudad)
                            <option value="{{ $ciudad->id }}">{{ $ciudad->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label>Calle</label>
                <input type="text" name="calle" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>

        <hr class="my-5">

        <h2 class="mb-4">Listado de Propiedades</h2>
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>Referencia</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Superficie</th>
                    <th>Habitaciones</th>
                    <th>Baños</th>
                    <th>Provincia</th>
                    <th>Ciudad</th>
                    <th>Calle</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($properties as $property)
                    <tr>
                        <td>{{ $property->referencia_interna }}</td>
                        <td>{{ $property->nombre }}</td>
                        <td>{{ $property->precio }}</td>
                        <td>{{ $property->superficie }}</td>
                        <td>{{ $property->habitaciones }}</td>
                        <td>{{ $property->baños }}</td>
                        <td>{{ $property->provincia->nombre ?? 'N/A' }}</td>
                        <td>{{ $property->ciudad->nombre ?? 'N/A' }}</td>
                        <td>{{ $property->calle }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS (opcional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
