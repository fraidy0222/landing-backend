<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'username' => 'administrador',
            'role' => 'Administrador'
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Lerdis',
            'last_name' => 'Regalado Pereira',
            'email' => 'lerdis@gmail.com',
            'username' => 'lerdis',
            'role' => 'Editor'
        ]);

        $categories = ['Nacional', 'Internacional', 'Deportes', 'Culturales'];

        foreach ($categories as $categoryName) {
            \App\Models\CategoriaNoticia::factory()->create([
                'nombre' => $categoryName,
            ]);
        }

        $estados = ['Revisión', 'Edición', 'Aprobado', 'Denegado'];

        foreach ($estados as $estadoName) {
            \App\Models\EstadoNoticia::factory()->create([
                'nombre' => $estadoName,
            ]);
        }
    }
}
