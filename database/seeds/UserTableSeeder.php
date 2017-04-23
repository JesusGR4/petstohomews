<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\DB;
class UserTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('user')->delete();

		// AdministratorUser
        User::create(array('name' => 'Jesús',
            'phone' => '658086507',
            'email' => 'jesgarrio@gmail.com',
            'province' => 'Sevilla',
            'role_id' => 1,
            'city' => 'Alcalá de Guadaíra',
            'password' => Hash::make('asdfasdf')));

		// ParticularUser

        for($i=0;$i<=10;$i++){
            User::create(array(
                'name' => 'Particular'.$i,
                'phone' => '654987321',
                'email' => 'particular'.$i.'@gmail.com',
                'province' => 'Sevilla',
                'role_id' => 2,
                'city' => 'Alcalá de Guadaíra',
                'password' => Hash::make('asdfasdf')
            ));
        }

		// ShelterUser
        $provinces = array("Álava","Ceuta", "Melilla", "Albacete", "Alicante", "Almería", "Asturias", "Ávila", "Badajoz", "Barcelona", "Burgos", "Cáceres", "Cádiz", "Cantabria", "Castellón", "Ciudad Real", "Córdoba", "Cuenca", "Girona", "Granada", "Guadalajara", "Guipúzcoa", "Huelva", "Huesca", "Islas Baleares", "Jaén", "La Coruña", "La Rioja", "Las Palmas", "León", "Lleida", "Lugo", "Madrid", "Málaga", "Murcia", "Navarra", "Ourense", "Palencia", "Pontevedra", "Salamanca", "Santa Cruz de Tenerife", "Segovia", "Sevilla", "Soria", "Tarragona", "Teruel", "Toledo", "Valencia", "Valladolid", "Vizcaya", "Zamora", "Zaragoza");

		for($i=0;$i<count($provinces);$i++){
            for($j=0;$j<=10;$j++){
                User::create(array(
                    'name' => 'Shelter'.$i.$j,
                    'phone' => '654321987',
                    'email' => 'shelter'.$i.$j.(rand()).'@gmail.com',
                    'province' => $provinces[$i],
                    'role_id' => 3,
                    'city' => 'Alcalá de Guadaíra',
                    'password' => Hash::make('asdfasdf')
                ));
            }
        }
	}
}