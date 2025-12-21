<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Propiedades</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light p-4">

    <div class="container">
        <h1>Editar Inmueble</h1>
        <form action="{{ route('properties.update', $property->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $property->nombre }}"
                    required>
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea name="descripcion" id="descripcion" class="form-control" required>{{ $property->descripcion }}</textarea>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label>Precio</label>
                    <input type="number" name="precio" step="0.01" class="form-control"
                        value="{{ $property->precio }}" required>
                </div>
                <div class="col">
                    <label>Superficie (m²)</label>
                    <input type="number" name="superficie" class="form-control" value="{{ $property->superficie }}"
                        required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label>Habitaciones</label>
                    <input type="number" name="habitaciones" class="form-control" value="{{ $property->habitaciones }}"
                        required>
                </div>
                <div class="col">
                    <label>Baños</label>
                    <input type="number" name="baños" class="form-control" value="{{ $property->baños }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label>Referencia Interna</label>
                <input type="text" name="referencia_interna" class="form-control"
                    value="{{ $property->referencia_interna }}">
            </div>

            <div class="mb-3">
                <label>Calle</label>
                <input type="text" name="calle" class="form-control" value="{{ $property->calle }}" required>
            </div>

            <div class="mb-3">
                <label>Actualizar Imagen(es)</label>
                <input type="file" name="imagen[]" id="imagenInputEdit" class="form-control" accept=".jpg" multiple>
                <div id="previewsEdit" class="mt-3 d-flex gap-2 flex-wrap">
                    <img src="{{ asset('storage/imagenes/' . $property->referencia_interna . '/foto.jpg') }}"
                        alt="imagenPropiedad" class="img-fluid border rounded"
                        style="width:120px;height:80px;object-fit:cover;">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label>Provincia</label>
                    <select name="provincia_id" id="provincia" class="form-select" required>
                        <option value="">Seleccione</option>
                        @foreach ($provincias as $provincia)
                            <option value="{{ $provincia->id }}"
                                {{ $property->provincia_id == $provincia->id ? 'selected' : '' }}>
                                {{ $provincia->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label>Ciudad</label>
                    <select name="ciudad_id" id="ciudad" class="form-select" required>
                        <option value="">Seleccione provincia primero</option>
                        @foreach ($ciudades as $ciudad)
                            <option value="{{ $ciudad->id }}"
                                {{ $property->ciudad_id == $ciudad->id ? 'selected' : '' }}>{{ $ciudad->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>


            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </form>
    </div>



    <!-- Bootstrap JS (opcional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
