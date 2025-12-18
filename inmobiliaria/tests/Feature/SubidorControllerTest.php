<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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

        // Usar disco falso y simular la solicitud POST
        Storage::fake('public');

        $response = $this->post('/upload', [
            'imagen' => $file,
            'referencia' => $referencia,
        ]);

        // Verificar que el archivo se haya guardado en el disco público
        $nombreArchivo = 'foto.jpg';
        Storage::disk('public')->assertExists('imagenes/' . $referencia . '/' . $nombreArchivo);

        // Verificar la redirección con el parámetro esperado
        $response->assertRedirect('/admin?ref=' . $referencia);

        // No es necesario limpiar al usar Storage::fake
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
