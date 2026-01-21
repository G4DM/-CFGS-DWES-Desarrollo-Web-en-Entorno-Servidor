<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Catalog;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the movie catalog
     */
    private function seedCatalog()
    {
        $peliculas = require __DIR__ . '/arrayPeliculas.php';

        foreach ($peliculas as $pelicula) {
            Catalog::create([
                'title'    => $pelicula['title'],
                'year'     => $pelicula['year'],
                'director' => $pelicula['director'],
                'poster'   => $pelicula['poster'],
                'rented'   => $pelicula['rented'],
                'synopsis' => $pelicula['synopsis']
            ]);
        }
    }

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->seedCatalog();
        $this->command->info('Tabla catálogo inicializada con datos!');
    }
}
