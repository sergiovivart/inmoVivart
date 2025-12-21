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

                    <form action="{{ route('admin.inmuebles.create') }}" method="POST" enctype="multipart/form-data">
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

                        <div class="row mb-3">
                            <div class="col">
                                <label>Seleccionar Imagen(es)</label>
                                <input type="file" name="imagen[]" id="imagenInput" class="form-control"
                                    accept=".jpg" multiple>
                                <div id="previews" class="mt-3 d-flex gap-2 flex-wrap"></div>
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
                                <img src="{{ asset('storage/imagenes/' . $property->referencia_interna . '/foto.jpg') }}"
                                    alt="imagenPropiedad" class="img-fluid" style="width: 100px; height: auto;">
                            </td>
                            <td>{{ $property->referencia_interna }}</td>
                            <td>{{ $property->nombre }}</td>
                            <td>
                                {{ number_format($property->precio, 0, ',', '.') }} €
                            </td>
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
        // Previsualización de imágenes múltiples antes de subir
        const imagenInput = document.getElementById('imagenInput');
        const previews = document.getElementById('previews');

        if (imagenInput) {
            imagenInput.addEventListener('change', function(e) {
                previews.innerHTML = '';
                const files = Array.from(e.target.files || []);

                files.forEach(file => {
                    if (!file.type.startsWith('image/')) return;

                    const reader = new FileReader();
                    const img = document.createElement('img');
                    img.style.width = '120px';
                    img.style.height = '80px';
                    img.style.objectFit = 'cover';
                    img.className = 'border rounded';

                    reader.onload = function(evt) {
                        img.src = evt.target.result;
                        previews.appendChild(img);
                    }

                    reader.readAsDataURL(file);
                });
            });
        }
    </script>


    <!-- Bootstrap JS (opcional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Actualiza el select de ciudades según la provincia seleccionada (AJAX)
        async function fetchCiudades(provinciaId, targetSelect) {
            if (!provinciaId) {
                targetSelect.innerHTML = '<option value="">Seleccione provincia primero</option>';
                return;
            }

            try {
                const res = await fetch(`/provincias/${provinciaId}/ciudades`);
                if (!res.ok) throw new Error('Network response not ok');
                const ciudades = await res.json();

                targetSelect.innerHTML = '<option value="">Seleccione</option>';
                ciudades.forEach(c => {
                    const opt = document.createElement('option');
                    opt.value = c.id;
                    opt.textContent = c.nombre;
                    targetSelect.appendChild(opt);
                });
            } catch (err) {
                console.error('Error cargando ciudades:', err);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const provinciaSelect = document.querySelector('#provincia');
            const ciudadSelect = document.querySelector('#ciudad');

            if (provinciaSelect && ciudadSelect) {
                provinciaSelect.addEventListener('change', function() {
                    fetchCiudades(this.value, ciudadSelect);
                });
            }
        });
    </script>
</body>

</html>
