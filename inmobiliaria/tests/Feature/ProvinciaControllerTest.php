<?php

namespace Tests\Feature;

use App\Models\Provincia;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProvinciaControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_creates_a_province_successfully(): void
    {
        // Datos válidos para la solicitud
        $data = [
            'nombre' => 'Provincia de Prueba',
        ];

        // Simular la solicitud POST
        $this->actingAs(User::factory()->create());
        $response = $this->post(route('provincias.store'), $data);

        // Verificar que el registro se haya creado en la base de datos
        $this->assertDatabaseHas('provincias', $data);

        // Verificar la redirección y el mensaje de éxito
        $response->assertRedirect(route('admin.index'));
        $response->assertSessionHas('success', 'Provincia creada.');
    }

    public function test_store_fails_validation_with_invalid_data(): void
    {
        // Datos inválidos (nombre vacío)
        $data = [
            'nombre' => '',
        ];

        // Simular la solicitud POST
        $this->actingAs(User::factory()->create());
        $response = $this->post(route('provincias.store'), $data);

        // Verificar que no se haya creado ningún registro
        $this->assertDatabaseMissing('provincias', ['nombre' => '']);

        // Verificar que se generen errores de validación
        $response->assertSessionHasErrors(['nombre']);
    }
}
