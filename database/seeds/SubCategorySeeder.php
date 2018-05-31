<?php

use Carbon\Carbon;
use App\SubCategory;
use Illuminate\Database\Seeder;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SubCategory::truncate();

        // Electrónicos, computadoras y oficina ---- ID = 1
        SubCategory::insert([
            ['created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'category_id' => 1, 'name' => 'TV y Video', 'slug' => 'tv-y-video'],
            ['created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'category_id' => 1, 'name' => 'Celulares y Accesorios', 'slug' => 'celulares-y-accesorios'],
            ['created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'category_id' => 1, 'name' => 'Computadoras y Accesorioss', 'slug' => 'computadoras-y-accesorios'],
            ['created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'category_id' => 1, 'name' => 'Componentes Para Computadoras', 'slug' => 'componentes-para-computadoras'],
        ]);

        // Deportes y Aire libre  ---- ID = 2
        SubCategory::insert([
            ['created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'category_id' => 2, 'name' => 'Deportes y Actividad Física', 'slug' => 'deportes-y-actividad-fisica'],
            ['created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'category_id' => 2, 'name' => 'ropa-deportiva', 'slug' => 'ropa-deportiva'],
        ]);


        // Hogar, Jardín y Herramientas  ---- ID = 3
        SubCategory::insert([
            ['created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'category_id' => 3, 'name' => 'Muebles', 'slug' => 'muebles'],
        ]);

        // Comida y Víveres  ---- ID = 4
        SubCategory::insert([
            ['created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'category_id' => 4, 'name' => 'Restaurantes', 'slug' => 'Restaurantes'],
            ['created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'category_id' => 4, 'name' => 'Pizza', 'slug' => 'pizza'],
        ]);

        // Belleza y Salud  ---- ID = 5
        SubCategory::insert([
            ['created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'category_id' => 5, 'name' => 'Mujeres', 'slug' => 'mujeres'],
            ['created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'category_id' => 5, 'name' => 'Hombres', 'slug' => 'hombres'],
            ['created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'category_id' => 5, 'name' => 'Niñas', 'slug' => 'girls'],
            ['created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'category_id' => 5, 'name' => 'Niños', 'slug' => 'boys'],
        ]);

        // Ropa, Calzado y Joyería  ---- ID = 6
        SubCategory::insert([
            ['created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'category_id' => 6, 'name' => 'Salon y Spa', 'slug' => 'salon-y-spa'],
        ]);

        // Automotriz e Industrial  ---- ID = 7
        SubCategory::insert([
            ['created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'category_id' => 7, 'name' => 'Partes y Accesorios Automotrices', 'slug' => 'partes-y-accesorios-automotrices'],
        ]);

        // Servicios para el hogar, empresas y organizacion  ---- ID = 8
        SubCategory::insert([
            ['created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'category_id' => 8, 'name' => 'Servicios de Limpieza', 'slug' => 'servicios-de-Limpieza'],
        ]);
    }
}
