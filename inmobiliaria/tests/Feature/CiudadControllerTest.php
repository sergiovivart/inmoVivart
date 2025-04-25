<?php

namespace Tests\Feature;

use App\Models\Provincia;
use App\Models\Ciudad;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CiudadControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_creates_a_city_successfully(): void
    {
        // Crear manualmente una provincia para asociar
        $provincia = Provincia::create([
            'nombre' => 'Provincia de Prueba',
        ]);

        // Datos válidos para la solicitud
        $data = [
            'nombre'       => 'Ciudad de Prueba',
            'provincia_id' => $provincia->id,
        ];

        // Simular la solicitud POST
        $response = $this->post(route('ciudades.store'), $data);

        // Verificar que el registro se haya creado en la base de datos
        $this->assertDatabaseHas('cities', $data);

        // Verificar la redirección y el mensaje de éxito
        $response->assertRedirect(route('admin.index'));
        $response->assertSessionHas('success', 'Ciudad creada.');
    }

    public function test_store_fails_validation_with_invalid_data(): void
    {
        // Datos inválidos (sin nombre y provincia_id inexistente)
        $data = [
            'nombre' => '',
            'provincia_id' => 999, // ID inexistente
        ];

        // Simular la solicitud POST
        $response = $this->post(route('ciudades.store'), $data);

        // Verificar que no se haya creado ningún registro
        $this->assertDatabaseMissing('cities', ['nombre' => '']);

        // Verificar que se generen errores de validación
        $response->assertSessionHasErrors(['nombre', 'provincia_id']);
    }
}
