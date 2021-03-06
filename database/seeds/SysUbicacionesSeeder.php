<?php

use Illuminate\Database\Seeder;
use App\Models\SysModel\SysUbicaciones;

class SysUbicacionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        SysUbicaciones::create(['id'=> 1,'name'=> 'Departamento Golf']);
        SysUbicaciones::create(['id'=> 2,'name'=> 'El Pangue']);
        SysUbicaciones::create(['id'=> 3,'name'=> 'Hall entrada departamento el Golf']);
        SysUbicaciones::create(['id'=> 4,'name'=> 'Oficina']);
        SysUbicaciones::create(['id'=> 5,'name'=> 'Bodega P.R. planera cajón 5']);
        SysUbicaciones::create(['id'=> 6,'name'=> 'Bodega P.R. planra gris cajon 3']);
        SysUbicaciones::create(['id'=> 7,'name'=> 'Bodega P.R. rack madera']);
        SysUbicaciones::create(['id'=> 8,'name'=> 'Bodega P.R. rieles']);
        SysUbicaciones::create(['id'=> 9,'name'=> 'Casa Patricia Subercaseaux']);
        SysUbicaciones::create(['id'=> 10,'name'=> 'Casa Antonia Cruz']);
        SysUbicaciones::create(['id'=> 11,'name'=> 'Hall edificio P.R.']);
        SysUbicaciones::create(['id'=> 12,'name'=> 'Bodega P.R. rack ']);
        SysUbicaciones::create(['id'=> 13,'name'=> 'Bodega P.R.']);

        SysUbicaciones::create(['id'=> 14,'name'=> 'Bodega P.R. Planera gris 3']);
        SysUbicaciones::create(['id'=> 15,'name'=> 'Bodega P.R. Planera gris cajón 4']);
        SysUbicaciones::create(['id'=> 16,'name'=> 'Bodega P.R. Planera negra cajón 1']);
        SysUbicaciones::create(['id'=> 17,'name'=> 'Casa Francisca Cruz']);
        SysUbicaciones::create(['id'=> 18,'name'=> 'Departamento P.R.']);

        SysUbicaciones::create(['id'=> 1000,'name'=> 'Sin Ubicación']);
    }
}
