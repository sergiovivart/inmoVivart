<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Propiedades</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light p-4">


    <div class="container">
        <div class="row">

            <div class="col col-lg-6 ">
                <div class="container">
                    <h2 class="mb-4">Crear Propiedad</h2>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <!-- resources/views/admin/subir-imagen.blade.php -->
                    <form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <div class="col">
                                <label>Seleccionar Imagen:</label>
                                <input type="file" name="imagen" id="imagenInput" required>

                                <br><br>
                                <img id="preview" style="max-width: 300px; display: none;" />
                                <br><br>

                            </div>
                            <div class="col">
                                <label for="referencia">Referencia Interna</label>
                                <input type="text" name="referencia" class="form-control" required>
                            </div>
                        </div>


                        <button class="btn btn-primary" type="submit">Subir Imagen</button>
                    </form>

                    <hr class="my-4">

                    <form action="{{ route('admin.inmuebles.create') }}" method="POST">
                        @csrf

                        <div class="row mb-3">
                            <div class="col">
                                <label>Referencia Interna</label>
                                <input type="text" name="referencia_interna" class="form-control"
                                    value="{{ request()->query('ref') ?? '' }}" required>
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
                </div>
            </div>

            <div class="col col-lg-6 ">

                <div id="crearProvincia" class="container">
                    <div class="container">
                        <h2 class="mb-4">Crear Provincia</h2>

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <form method="POST" action="{{ route('provincias.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Nombre</label>
                                <input type="text" name="nombre" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Guardar Provincia</button>
                        </form>
                    </div>
                </div>

                {{-- fin del crear provincia  --}}

                <div id="crearCiudad" class="container">

                    <h2 class="mb-4">Crear Ciudad</h2>

                    <form method="POST" action="{{ route('ciudades.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="nombre" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Provincia</label>
                            <select name="provincia_id" class="form-select" required>
                                <option value="">Seleccione una provincia</option>
                                @foreach ($provincias as $provincia)
                                    <option value="{{ $provincia->id }}">{{ $provincia->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Guardar Ciudad</button>
                    </form>

                </div>
                {{-- fin del crear ciudad --}}

            </div>

        </div>
    </div>

    <div class="container">
        <div class="row mt-5">
            <h2 class="mb-4">Listado de Propiedades</h2>
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Imagen</th>
                        <th>Referencia</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Superficie</th>
                        <th>Habitaciones</th>
                        <th>Baños</th>
                        <th>Provincia</th>
                        <th>Ciudad</th>
                        <th>Calle</th>
                        <th>opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($properties as $property)
                        <tr>
                            <td>
                                <img src="/imagenes/{{ $property->referencia_interna }}/foto.jpg"
                                    alt="imagenPropiedad" class="img-fluid" style="width: 100px; height: auto;">
                            </td>
                            <td>{{ $property->referencia_interna }}</td>
                            <td>{{ $property->nombre }}</td>
                            <td>{{ $property->precio }}</td>
                            <td>{{ $property->superficie }}</td>
                            <td>{{ $property->habitaciones }}</td>
                            <td>{{ $property->baños }}</td>
                            <td>{{ $property->provincia->nombre ?? 'N/A' }}</td>
                            <td>{{ $property->city->nombre ?? 'N/A' }}</td>
                            <td>{{ $property->calle }}</td>
                            <td>
                                <a class="btn" href="/admin/destroy/{{ $property->id }}">
                                    eliminar
                                </a>

                                <a class="btn" href="/admin/edit/{{ $property->id }}">
                                    editar</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <script>
        // para verificar la imagen 
        document.getElementById('imagenInput').addEventListener('change', function(e) {
            const preview = document.getElementById('preview');
            const file = e.target.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }

                reader.readAsDataURL(file);
            } else {
                preview.src = '';
                preview.style.display = 'none';
            }
        });
    </script>


    <!-- Bootstrap JS (opcional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
