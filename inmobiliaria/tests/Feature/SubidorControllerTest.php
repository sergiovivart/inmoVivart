<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class SubidorControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_image_upload_successfully(): void
    {
        // Simular un archivo de imagen
        $file = UploadedFile::fake()->image('test-image.jpg');

        // Parámetro de referencia
        $referencia = 'test-referencia';

        // Simular la solicitud POST
        $response = $this->post('/upload', [
            'imagen' => $file,
            'referencia' => $referencia,
        ]);

        // Verificar que el archivo se haya guardado en la ubicación correcta
        $rutaCarpeta = public_path('imagenes/' . $referencia);
        $nombreArchivo = 'foto.jpg';

        $this->assertTrue(File::exists($rutaCarpeta . '/' . $nombreArchivo));

        // Verificar la redirección con el parámetro esperado
        $response->assertRedirect('/admin?ref=' . $referencia);

        // Limpiar el entorno de prueba eliminando el archivo y la carpeta
        File::deleteDirectory(public_path('imagenes/' . $referencia));
    }

    public function test_image_upload_validation_fails(): void
    {
        // Simular una solicitud POST sin archivo
        $response = $this->post('/upload', [
            'referencia' => 'test-referencia',
        ]);

        // Verificar que se devuelvan errores de validación
        $response->assertSessionHasErrors(['imagen']);
    }
}
