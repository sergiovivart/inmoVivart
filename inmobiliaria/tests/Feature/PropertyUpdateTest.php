<?php

namespace Tests\Feature;

use App\Models\Property;
use App\Models\Provincia;
use App\Models\Ciudad;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class PropertyUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_persists_changes()
    {
        $provincia = Provincia::create(['nombre' => 'Provincia Test']);
        $ciudad = Ciudad::create(['nombre' => 'Ciudad Test', 'provincia_id' => $provincia->id]);

        $property = Property::create([
            'referencia_interna' => 'ref-old',
            'nombre' => 'Old Name',
            'descripcion' => 'Old desc',
            'precio' => 50000,
            'superficie' => 50,
            'habitaciones' => 2,
            'baños' => 1,
            'provincia_id' => $provincia->id,
            'ciudad_id' => $ciudad->id,
            'calle' => 'Old Street'
        ]);

        $data = [
            'referencia_interna' => 'ref-old',
            'nombre' => 'New Name',
            'descripcion' => 'New desc',
            'precio' => 75000,
            'superficie' => 75,
            'habitaciones' => 3,
            'baños' => 2,
            'provincia_id' => $provincia->id,
            'ciudad_id' => $ciudad->id,
            'calle' => 'New Street'
        ];

        $this->actingAs(User::factory()->create());
        $response = $this->put(route('properties.update', $property->id), $data);

        $response->assertRedirect(route('admin.index'));

        $property->refresh();
        $this->assertEquals('New Name', $property->nombre);
        $this->assertEquals('New desc', $property->descripcion);
        $this->assertEquals(75000, $property->precio);
        $this->assertDatabaseHas('properties', ['id' => $property->id, 'nombre' => 'New Name']);
    }

    public function test_update_validation_fails_with_invalid_data()
    {
        $provincia = Provincia::create(['nombre' => 'Provincia Test']);
        $ciudad = Ciudad::create(['nombre' => 'Ciudad Test', 'provincia_id' => $provincia->id]);

        $property = Property::create([
            'referencia_interna' => 'ref-1',
            'nombre' => 'Name',
            'descripcion' => 'Desc',
            'precio' => 1000,
            'superficie' => 10,
            'habitaciones' => 1,
            'baños' => 1,
            'provincia_id' => $provincia->id,
            'ciudad_id' => $ciudad->id,
            'calle' => 'Street'
        ]);

        $invalid = [
            'nombre' => '',
            'descripcion' => '',
            // missing precio, superficie, etc.
        ];

        $this->actingAs(User::factory()->create());
        $response = $this->put(route('properties.update', $property->id), $invalid);

        $response->assertSessionHasErrors(['nombre', 'descripcion', 'precio', 'superficie', 'habitaciones', 'baños', 'provincia_id', 'ciudad_id', 'calle']);
    }

    public function test_referencia_uniqueness_on_update()
    {
        $provincia = Provincia::create(['nombre' => 'Provincia Test']);
        $ciudad = Ciudad::create(['nombre' => 'Ciudad Test', 'provincia_id' => $provincia->id]);

        $p1 = Property::create([
            'referencia_interna' => 'REF-A',
            'nombre' => 'P1',
            'descripcion' => 'D1',
            'precio' => 100,
            'superficie' => 10,
            'habitaciones' => 1,
            'baños' => 1,
            'provincia_id' => $provincia->id,
            'ciudad_id' => $ciudad->id,
            'calle' => 'C1'
        ]);

        $p2 = Property::create([
            'referencia_interna' => 'REF-B',
            'nombre' => 'P2',
            'descripcion' => 'D2',
            'precio' => 200,
            'superficie' => 20,
            'habitaciones' => 2,
            'baños' => 1,
            'provincia_id' => $provincia->id,
            'ciudad_id' => $ciudad->id,
            'calle' => 'C2'
        ]);

        $data = [
            'referencia_interna' => 'REF-A', // collide with p1
            'nombre' => 'P2-up',
            'descripcion' => 'D2',
            'precio' => 250,
            'superficie' => 25,
            'habitaciones' => 3,
            'baños' => 2,
            'provincia_id' => $provincia->id,
            'ciudad_id' => $ciudad->id,
            'calle' => 'C2'
        ];

        $this->actingAs(User::factory()->create());
        $response = $this->put(route('properties.update', $p2->id), $data);

        $response->assertSessionHasErrors(['referencia_interna']);
    }

    public function test_ajax_provincia_ciudades_returns_json()
    {
        $provincia = Provincia::create(['nombre' => 'Provincia Test']);
        Ciudad::create(['nombre' => 'C1', 'provincia_id' => $provincia->id]);
        Ciudad::create(['nombre' => 'C2', 'provincia_id' => $provincia->id]);

        $response = $this->getJson(route('provincias.ciudades', $provincia->id));
        $response->assertOk();
        $response->assertJsonCount(2);
    }
}
