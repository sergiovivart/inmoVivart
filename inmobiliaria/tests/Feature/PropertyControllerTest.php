<?php

namespace Tests\Feature;

use App\Models\Property;
use App\Models\Provincia;
use App\Models\Ciudad;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class PropertyControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_displays_properties(): void
    {
        $provincia = Provincia::create(['nombre' => 'Provincia Test']);
        $ciudad = Ciudad::create(['nombre' => 'Ciudad Test', 'provincia_id' => $provincia->id]);
        Property::create([
            'referencia_interna' => 'test-ref', // Agrega este campo
            'nombre' => 'Propiedad Test',
            'descripcion' => 'Descripción Test',
            'precio' => 100000.00,
            'superficie' => 100.00,
            'habitaciones' => 3,
            'baños' => 2,
            'provincia_id' => 1,
            'ciudad_id' => 1,
            'calle' => 'Calle Test'
        ]);

        // que hace esta linea de codigo?
        $response = $this->get(route('inmuebles.index'));

        $response->assertStatus(200);
        $response->assertViewHas('propiedades');
        $response->assertViewHas('provincias');
        $response->assertViewHas('ciudades');
    }

    public function test_create_creates_a_property(): void
    {
        $provincia = Provincia::create(['nombre' => 'Provincia Test']);
        $ciudad = Ciudad::create(['nombre' => 'Ciudad Test', 'provincia_id' => $provincia->id]);

        $data = [
            'referencia_interna' => 'test-ref', // Agrega este campo
            'nombre' => 'Propiedad Test',
            'descripcion' => 'Descripción Test',
            'precio' => 100000.00,
            'superficie' => 100.00,
            'habitaciones' => 3,
            'baños' => 2,
            'provincia_id' => 1,
            'ciudad_id' => 1,
            'calle' => 'Calle Test'
        ];

        $response = $this->post(route('admin.inmuebles.create'), $data);

        $this->assertDatabaseHas('properties', $data);
        $response->assertRedirect(route('admin.index'));
    }

    public function test_edit_displays_edit_view(): void
    {
        $provincia = Provincia::create(['nombre' => 'Provincia Test']);
        $ciudad = Ciudad::create(['nombre' => 'Ciudad Test', 'provincia_id' => $provincia->id]);

        $property = Property::create([
            'referencia_interna' => 'test-ref001', // Agrega este campo
            'nombre' => 'Propiedad Test',
            'descripcion' => 'Descripción Test',
            'precio' => 100000.00,
            'superficie' => 100.00,
            'habitaciones' => 3,
            'baños' => 2,
            'provincia_id' => $provincia->id, // Usa el ID correcto
            'ciudad_id' => $ciudad->id,       // Usa el ID correcto
            'calle' => 'Calle Test'
        ]);

        $response = $this->get(route('admin.inmuebles.edit', $property->id));

        $response->assertStatus(200);
        $response->assertViewHas('property', $property);
    }

    public function test_update_updates_a_property(): void
    {

        $provincia = Provincia::create(['nombre' => 'Provincia Test']);
        $ciudad = Ciudad::create(['nombre' => 'Ciudad Test', 'provincia_id' => $provincia->id]);


        $property = Property::create([
            'referencia_interna' => 'test-ref001', // Agrega este campo
            'nombre' => 'Propiedad Test',
            'descripcion' => 'Descripción Test',
            'precio' => 100000.00,
            'superficie' => 100.00,
            'habitaciones' => 3,
            'baños' => 2,
            'provincia_id' => $provincia->id, // Usa el ID correcto
            'ciudad_id' => $ciudad->id,       // Usa el ID correcto
            'calle' => 'Calle Test'
        ]);

        $data = [
            'referencia_interna' => 'test-ref001', // Agrega este campo
            'nombre' => 'Propiedad Test', // Valor actualizado
            'descripcion' => 'Descripción Test', // Valor actualizado
            'precio' => 100000.00,
            'superficie' => 100.00,
            'habitaciones' => 3,
            'baños' => 2,
            'provincia_id' => $provincia->id, // Usa el ID correcto
            'ciudad_id' => $ciudad->id,       // Usa el ID correcto
            'calle' => 'Calle Test'
        ];

        $response = $this->put(route('properties.update', $property->id), $data);

        $this->assertEquals('Propiedad Test', $property->nombre);
        $this->assertEquals('Descripción Test', $property->descripcion);
        // $response->assertRedirect(route('admin.index'));
    }

    public function test_destroy_deletes_a_property(): void
    {

        $provincia = Provincia::create(['nombre' => 'Provincia Test']);
        $ciudad = Ciudad::create(['nombre' => 'Ciudad Test', 'provincia_id' => $provincia->id]);
        $property = Property::create([
            'referencia_interna' => 'test-ref', // Agrega este campo
            'nombre' => 'Propiedad Test',
            'descripcion' => 'Descripción Test',
            'precio' => 100000.00,
            'superficie' => 100.00,
            'habitaciones' => 3,
            'baños' => 2,
            'provincia_id' => $provincia->id, // Usa el ID correcto
            'ciudad_id' => $ciudad->id,       // Usa el ID correcto
            'calle' => 'Calle Test'
        ]);

        // Crear una carpeta simulada para la propiedad
        $carpeta = public_path('imagenes/test-ref');

        // corremos la funcion
        $response = $this->get(route('admin.inmuebles.delete', $property->id));

        $this->assertSoftDeleted('properties', ['id' => $property->id]);
        $this->assertFalse(File::exists($carpeta));
        $response->assertRedirect(route('admin.index'));
    }
}
