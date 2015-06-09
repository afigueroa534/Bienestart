<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//base de datos
		Schema::create('persona', function(Blueprint $table)
		{

			$table->string('cedula',12);
			$table->string('login',30)->unique();
			$table->string('nombre',30);
			$table->string('apellido',30);
			$table->string('direccion', 50);
			$table->string('email',50)->unique();
			$table->string('clave',100);
			$table->date('fecha_nac');
			$table->string('telefono',11);
			$table->string('tipo_per',1);
			$table->string('sexo',1);
			$table->string('imagen',30)->default('NoImagen.jpg');
			$table->rememberToken();
			$table->timestamps();

			$table->primary('cedula');

		});

		Schema::create('medico', function(Blueprint $table)
		{

			$table->string('cedula',12);
			$table->integer('num_medico')->unsigned();
			$table->string('especialidad',50);
			$table->rememberToken();
			$table->timestamps();

			$table->primary('cedula');
			$table->foreign('cedula')
			      ->references('cedula')->on('persona')
			      ->onDelete('cascade')->onUpdate('cascade');

		});

		Schema::create('evento', function(Blueprint $table)
		{

			$table->string('cedula',12);
			$table->integer('id_evento')->unsigned();
			$table->string('descripcion',50);
			$table->date('fecha_inicio');
			$table->date('fecha_final');
			$table->rememberToken();
			$table->timestamps();

			$table->primary(['cedula','id_evento']);
			$table->foreign('cedula')
			      ->references('cedula')->on('medico')
			      ->onDelete('cascade')->onUpdate('cascade');

		});

		Schema::create('paciente', function(Blueprint $table)
		{

			$table->string('cedula',12);
			$table->string('grupo_sangre',5);
			$table->rememberToken();
			$table->timestamps();

			$table->primary('cedula');
			$table->foreign('cedula')
			      ->references('cedula')->on('persona')
			      ->onDelete('cascade')->onUpdate('cascade');

		});

		Schema::create('antecedente', function(Blueprint $table)
		{

			$table->string('cedula',12);
			$table->integer('id_antecedente')->unsigned();
			$table->integer('edad')->unsigned();
			$table->text('descripcion');
			$table->rememberToken();
			$table->timestamps();

			$table->primary(['cedula','id_antecedente']);
			$table->foreign('cedula')
			      ->references('cedula')->on('paciente')
			      ->onDelete('cascade')->onUpdate('cascade');

		});

		Schema::create('cita', function(Blueprint $table)
		{

			$table->string('cedula_paciente',12);
			$table->date('fecha');
			$table->time('hora');
			$table->string('estado',1);
			$table->string('cedula_medico',12);
			$table->rememberToken();
			$table->timestamps();

			$table->primary(['cedula_paciente','fecha','hora']);
			$table->foreign('cedula_paciente')
			      ->references('cedula')->on('paciente')
			      ->onDelete('cascade')->onUpdate('cascade');

			$table->foreign('cedula_medico')
			      ->references('cedula')->on('medico')
			      ->onDelete('cascade')->onUpdate('cascade');

		});	

		Schema::create('consulta', function(Blueprint $table)
		{

			$table->string('cedula_paciente',12);
			$table->date('fecha');
			$table->time('hora');
			$table->text('motivo');
			$table->text('diagnostico')->nullable();
			$table->rememberToken();
			$table->timestamps();

			$table->primary(['cedula_paciente','fecha','hora']);
			$table->foreign(['cedula_paciente','fecha','hora'])
			      ->references(['cedula_paciente','fecha','hora'])->on('cita')
			      ->onDelete('cascade')->onUpdate('cascade');

		});		

		Schema::create('tratamiento', function(Blueprint $table)
		{

			$table->string('cedula_paciente',12);
			$table->date('fecha');
			$table->time('hora');
			$table->integer('id_tratamiento')->unsigned();
			$table->text('descripcion');
			$table->rememberToken();
			$table->timestamps();

			$table->primary(['cedula_paciente','fecha','hora','id_tratamiento']);
			$table->foreign(['cedula_paciente','fecha','hora'])
			      ->references(['cedula_paciente','fecha','hora'])->on('consulta')
			      ->onDelete('cascade')->onUpdate('cascade');

		});	


	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tratamiento');
		Schema::drop('consulta');
		Schema::drop('cita');
		Schema::drop('antecedente');
		Schema::drop('paciente');
		Schema::drop('evento');
		Schema::drop('medico');
		Schema::drop('persona');
	}

}
