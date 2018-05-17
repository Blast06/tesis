<?php

use App\Category;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::truncate();

        Category::insert([
            ['created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'name' => 'Electrónicos, computadoras y oficina', 'slug' => 'electrónicos-computadoras-y-oficina'],
            ['created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'name' => 'Deportes y Aire libre', 'slug' => 'deportes-y-aire-libre'],
            ['created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'name' => 'Hogar, Jardín y Herramientas', 'slug' => 'hogar-Jardín-y-herramientas'],
            ['created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'name' => 'Comida y Víveres', 'slug' => 'comida-y-viveres'],
            ['created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'name' => 'Belleza y Salud', 'slug' => 'belleza-y-salud'],
            ['created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'name' => 'Ropa, Calzado y Joyería', 'slug' => 'ropa-calzado-y-joyería'],
            ['created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'name' => 'Automotriz e Industrial', 'slug' => 'automotriz-e-industrial'],
            ['created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'name' => 'Servicios para el hogar, empresas y organizacion', 'slug' => 'servicios-para-el-hogar-empresas-y-organizacion'],
        ]);
    }
}
