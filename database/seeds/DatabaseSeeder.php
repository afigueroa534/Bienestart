<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{

		/*
		Administrador por default
		*/
		DB::table('persona')->insert(array(

				'cedula' => 'V1',
				'login'  => 'root',
				'nombre' => 'Admin',
				'apellido' => 'Admin',
				'direccion' => 'Direccion',
				'email' => 'Email@Email',
				'clave' => password_hash('root', PASSWORD_DEFAULT),
				'fecha_nac' => '2000-10-10',
				'telefono' => '0800',
				'tipo_per' => 'A',
				'sexo' => 'M',
				'imagen' => 'NoImagen.jpg'

				));

		/*
		Medico por default
		*/
		DB::table('persona')->insert(array(

				'cedula' => 'V2',
				'login'  => 'asdfg',
				'nombre' => 'Medico',
				'apellido' => 'Medico',
				'direccion' => 'Direccion',
				'email' => 'Email@Hotmail',
				'clave' => password_hash('asdfg', PASSWORD_DEFAULT),
				'fecha_nac' => '2000-10-10',
				'telefono' => '0800',
				'tipo_per' => 'M',
				'sexo' => 'M',
				'imagen' => 'NoImagen.jpg'

				));
		DB::table('medico')->insert(array(

				'cedula' => 'V2',
				'num_medico'  => '0101',
				'especialidad' => 'General',

				));

		/*
		Paciente por default
		*/
		DB::table('persona')->insert(array(

				'cedula' => 'V3',
				'login'  => 'zxcvb',
				'nombre' => 'Paciente',
				'apellido' => 'Paciente',
				'direccion' => 'Direccion',
				'email' => 'Email@Gmail',
				'clave' => password_hash('zxcvb', PASSWORD_DEFAULT),
				'fecha_nac' => '2000-10-10',
				'telefono' => '0800',
				'tipo_per' => 'P',
				'sexo' => 'M',
				'imagen' => 'NoImagen.jpg'

				));
		DB::table('paciente')->insert(array(

				'cedula' => 'V3',
				'grupo_sangre'  => 'A+'

				));

		$faker = Faker::create();

		/*
		Paciente
		*/
		for($i = 0; $i <= 30; $i++){

			$login = $faker->unique()->userName;
			$cedula = $faker->randomElement($array = array ('V','E')).$faker->unique()->numberBetween($min = 8000000, $max = 30000000);
			$tipo_per = $faker->randomElement($array = array ('P','M'));
			DB::table('persona')->insert(array(

				'cedula' => $cedula,
				'login'  => $login,
				'nombre' => $faker->firstName,
				'apellido' => $faker->lastName,
				'direccion' => $faker->address,
				'email' => $faker->unique()->email,
				'clave' => password_hash($login, PASSWORD_DEFAULT),
				'fecha_nac' => $faker->date($format = 'Y-m-d', $max = 'now'),
				'telefono' => $faker->phoneNumber,
				'tipo_per' => $tipo_per,
				'sexo' => $faker->randomElement($array = array ('M','F')),
				'imagen' => 'NoImagen.jpg'

				));

			if($tipo_per == 'P'){

				DB::table('paciente')->insert(array(

					'cedula' => $cedula,
					'grupo_sangre'  => $faker->randomElement($array = array ('A+','A-','O+','O-','B+','B-','AB+','AB-'))

					));

				/*
				Antecedentes
				*/
				for ($j = 1; $j <= 2; $j++) { 
					
					$fecha_final = $faker->date($format = 'Y-m-d', $max = 'now');
					$fecha_inicio =  $faker->date($format = 'Y-m-d', $max = $fecha_final);

					DB::table('antecedente')->insert(array(

						'cedula' => $cedula,
						'id_antecedente' => $j,
						'descripcion'  => $faker->text($maxNbChars = 200),
						'edad'  =>  $faker->unique()->numberBetween($min = 0, $max = 130)
					
					));

				}

				/*
				Citas
				*/
				for ($j = 1; $j <= 2; $j++) { 

					DB::table('cita')->insert(array(

						'cedula_paciente' => $cedula,
						'fecha' => $faker->date($format = 'Y-m-d', $max = 'now'),
						// Horas por defecto
						'hora'  => $faker->randomElement($array = array ('08:00:00','09:00:00','10:00:00','14:00:00','15:00:00','16:00:00')),
						// Estados P = Pendiente, C = Cancelada, R = Realizada
						'estado'  =>  $faker->randomElement($array = array ('P','C','R')),
						'cedula_medico'  =>  'V2'
					
					));

				}
			}
			else
			{
				/*
				Medico
				*/
				DB::table('medico')->insert(array(

					'cedula' => $cedula,
					'num_medico'  => $faker->unique()->numberBetween($min = 100000, $max = 30000000),
					'especialidad' => $faker->randomElement($array = array ('General','Internista','Pediatria','Geriatria','Neumologia','Odontologia','Psiquiatria')),
					));

				for ($j = 1; $j <= 2; $j++) { 
					
					$fecha_final = $faker->date($format = 'Y-m-d', $max = 'now');
					$fecha_inicio =  $faker->date($format = 'Y-m-d', $max = $fecha_final);

					DB::table('evento')->insert(array(

						'cedula' => $cedula,
						'id_evento' => $j,
						'descripcion'  => $faker->randomElement($array = array ('Vacacion','Convencion','Reunion','Motivo Personal')),
						'fecha_inicio'  =>  $fecha_inicio,
						'fecha_final'  =>  $fecha_final
					
					));

				}
			}
		}
	}

}
